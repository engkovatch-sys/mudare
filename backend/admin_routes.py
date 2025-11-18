from fastapi import APIRouter, HTTPException, Depends, UploadFile, File, Request, Response
from fastapi.responses import JSONResponse
from typing import List, Optional
import os
import uuid
import shutil
from passlib.context import CryptContext
from datetime import datetime
from models import (
    UserLogin, Project, ProjectCreate, ProjectUpdate,
    Architect, ArchitectCreate,
    Testimonial, TestimonialCreate, TestimonialUpdate,
    Service, ServiceUpdate,
    CompanyInfo, CompanyInfoUpdate
)

router = APIRouter(prefix="/admin", tags=["admin"])
pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")

# Temporary in-memory session storage (in production, use Redis or JWT)
active_sessions = set()

UPLOAD_DIR = "/app/frontend/public/uploads"
os.makedirs(UPLOAD_DIR, exist_ok=True)

# Dependency to check if user is authenticated
async def get_current_user(request: Request):
    session_id = request.cookies.get("admin_session")
    if not session_id or session_id not in active_sessions:
        raise HTTPException(status_code=401, detail="Not authenticated")
    return session_id

# Auth endpoints
@router.post("/login")
async def login(user_login: UserLogin, response: Response, db=Depends(lambda: None)):
    from server import db as database
    
    # Check if user exists
    user = await database.admin_users.find_one({"username": user_login.username})
    
    if not user:
        # Create default admin user if doesn't exist
        if user_login.username == "admin" and user_login.password == "mudare2024":
            hashed_password = pwd_context.hash(user_login.password)
            await database.admin_users.insert_one({
                "id": str(uuid.uuid4()),
                "username": "admin",
                "password": hashed_password,
                "created_at": datetime.utcnow()
            })
            session_id = str(uuid.uuid4())
            active_sessions.add(session_id)
            response.set_cookie(key="admin_session", value=session_id, httponly=True)
            return {"message": "Login successful", "username": "admin"}
        raise HTTPException(status_code=401, detail="Invalid credentials")
    
    # Verify password
    if not pwd_context.verify(user_login.password, user["password"]):
        raise HTTPException(status_code=401, detail="Invalid credentials")
    
    # Create session
    session_id = str(uuid.uuid4())
    active_sessions.add(session_id)
    response.set_cookie(key="admin_session", value=session_id, httponly=True)
    
    return {"message": "Login successful", "username": user["username"]}

@router.post("/logout")
async def logout(response: Response, session_id: str = Depends(get_current_user)):
    active_sessions.discard(session_id)
    response.delete_cookie("admin_session")
    return {"message": "Logged out successfully"}

@router.get("/check")
async def check_auth(session_id: str = Depends(get_current_user)):
    return {"authenticated": True}

# Project endpoints
@router.get("/projects", response_model=List[Project])
async def get_projects(session_id: str = Depends(get_current_user)):
    from server import db
    projects = await db.projects.find().to_list(1000)
    return projects

@router.post("/projects", response_model=Project)
async def create_project(project: ProjectCreate, session_id: str = Depends(get_current_user)):
    from server import db
    project_dict = project.dict()
    project_obj = Project(**project_dict)
    await db.projects.insert_one(project_obj.dict())
    return project_obj

@router.put("/projects/{project_id}", response_model=Project)
async def update_project(project_id: str, project_update: ProjectUpdate, session_id: str = Depends(get_current_user)):
    from server import db
    
    existing_project = await db.projects.find_one({"id": project_id})
    if not existing_project:
        raise HTTPException(status_code=404, detail="Project not found")
    
    update_data = {k: v for k, v in project_update.dict().items() if v is not None}
    update_data["updated_at"] = datetime.utcnow()
    
    await db.projects.update_one({"id": project_id}, {"$set": update_data})
    
    updated_project = await db.projects.find_one({"id": project_id})
    return Project(**updated_project)

@router.delete("/projects/{project_id}")
async def delete_project(project_id: str, session_id: str = Depends(get_current_user)):
    from server import db
    
    result = await db.projects.delete_one({"id": project_id})
    if result.deleted_count == 0:
        raise HTTPException(status_code=404, detail="Project not found")
    
    return {"message": "Project deleted successfully"}

@router.post("/projects/upload")
async def upload_image(file: UploadFile = File(...), session_id: str = Depends(get_current_user)):
    file_extension = os.path.splitext(file.filename)[1]
    file_name = f"{uuid.uuid4()}{file_extension}"
    file_path = os.path.join(UPLOAD_DIR, file_name)
    
    with open(file_path, "wb") as buffer:
        shutil.copyfileobj(file.file, buffer)
    
    return {"url": f"/uploads/{file_name}"}

# Architect endpoints
@router.get("/architects", response_model=List[Architect])
async def get_architects(session_id: str = Depends(get_current_user)):
    from server import db
    architects = await db.architects.find().sort("order", 1).to_list(1000)
    return architects

@router.post("/architects", response_model=Architect)
async def create_architect(architect: ArchitectCreate, session_id: str = Depends(get_current_user)):
    from server import db
    architect_obj = Architect(**architect.dict())
    await db.architects.insert_one(architect_obj.dict())
    return architect_obj

@router.put("/architects/{architect_id}", response_model=Architect)
async def update_architect(architect_id: str, architect_update: ArchitectCreate, session_id: str = Depends(get_current_user)):
    from server import db
    
    await db.architects.update_one(
        {"id": architect_id},
        {"$set": architect_update.dict()}
    )
    
    updated = await db.architects.find_one({"id": architect_id})
    if not updated:
        raise HTTPException(status_code=404, detail="Architect not found")
    return Architect(**updated)

@router.delete("/architects/{architect_id}")
async def delete_architect(architect_id: str, session_id: str = Depends(get_current_user)):
    from server import db
    
    result = await db.architects.delete_one({"id": architect_id})
    if result.deleted_count == 0:
        raise HTTPException(status_code=404, detail="Architect not found")
    
    return {"message": "Architect deleted successfully"}

# Testimonial endpoints
@router.get("/testimonials", response_model=List[Testimonial])
async def get_testimonials(session_id: str = Depends(get_current_user)):
    from server import db
    testimonials = await db.testimonials.find().to_list(1000)
    return testimonials

@router.post("/testimonials", response_model=Testimonial)
async def create_testimonial(testimonial: TestimonialCreate, session_id: str = Depends(get_current_user)):
    from server import db
    testimonial_obj = Testimonial(**testimonial.dict())
    await db.testimonials.insert_one(testimonial_obj.dict())
    return testimonial_obj

@router.put("/testimonials/{testimonial_id}", response_model=Testimonial)
async def update_testimonial(testimonial_id: str, testimonial_update: TestimonialUpdate, session_id: str = Depends(get_current_user)):
    from server import db
    
    update_data = {k: v for k, v in testimonial_update.dict().items() if v is not None}
    await db.testimonials.update_one({"id": testimonial_id}, {"$set": update_data})
    
    updated = await db.testimonials.find_one({"id": testimonial_id})
    if not updated:
        raise HTTPException(status_code=404, detail="Testimonial not found")
    return Testimonial(**updated)

@router.delete("/testimonials/{testimonial_id}")
async def delete_testimonial(testimonial_id: str, session_id: str = Depends(get_current_user)):
    from server import db
    
    result = await db.testimonials.delete_one({"id": testimonial_id})
    if result.deleted_count == 0:
        raise HTTPException(status_code=404, detail="Testimonial not found")
    
    return {"message": "Testimonial deleted successfully"}

# Service endpoints
@router.get("/services", response_model=List[Service])
async def get_services(session_id: str = Depends(get_current_user)):
    from server import db
    services = await db.services.find().sort("order", 1).to_list(1000)
    return services

@router.put("/services/{service_id}", response_model=Service)
async def update_service(service_id: str, service_update: ServiceUpdate, session_id: str = Depends(get_current_user)):
    from server import db
    
    update_data = {k: v for k, v in service_update.dict().items() if v is not None}
    await db.services.update_one({"id": service_id}, {"$set": update_data})
    
    updated = await db.services.find_one({"id": service_id})
    if not updated:
        raise HTTPException(status_code=404, detail="Service not found")
    return Service(**updated)

# Company Info endpoints
@router.get("/company-info", response_model=CompanyInfo)
async def get_company_info(session_id: str = Depends(get_current_user)):
    from server import db
    
    company_info = await db.company_info.find_one({})
    if not company_info:
        raise HTTPException(status_code=404, detail="Company info not found")
    return CompanyInfo(**company_info)

@router.put("/company-info", response_model=CompanyInfo)
async def update_company_info(company_update: CompanyInfoUpdate, session_id: str = Depends(get_current_user)):
    from server import db
    
    update_data = {k: v for k, v in company_update.dict().items() if v is not None}
    update_data["updated_at"] = datetime.utcnow()
    
    await db.company_info.update_one({}, {"$set": update_data})
    
    updated = await db.company_info.find_one({})
    if not updated:
        raise HTTPException(status_code=404, detail="Company info not found")
    return CompanyInfo(**updated)
