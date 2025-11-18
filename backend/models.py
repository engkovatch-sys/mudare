from pydantic import BaseModel, Field
from typing import Optional, List
from datetime import datetime
import uuid

# Auth Models
class UserLogin(BaseModel):
    username: str
    password: str

class User(BaseModel):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))
    username: str
    password: str
    created_at: datetime = Field(default_factory=datetime.utcnow)

# Project Models
class ProjectCreate(BaseModel):
    title: str
    category: str
    location: str
    architect: str
    year: int
    area: str
    description: str
    story: str
    image: str
    featured: bool = False

class ProjectUpdate(BaseModel):
    title: Optional[str] = None
    category: Optional[str] = None
    location: Optional[str] = None
    architect: Optional[str] = None
    year: Optional[int] = None
    area: Optional[str] = None
    description: Optional[str] = None
    story: Optional[str] = None
    image: Optional[str] = None
    featured: Optional[bool] = None

class Project(ProjectCreate):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))
    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: datetime = Field(default_factory=datetime.utcnow)

# Architect Models
class ArchitectCreate(BaseModel):
    name: str
    order: int = 0

class Architect(ArchitectCreate):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))

# Testimonial Models
class TestimonialCreate(BaseModel):
    name: str
    role: str
    project: str
    content: str
    rating: int = 5

class TestimonialUpdate(BaseModel):
    name: Optional[str] = None
    role: Optional[str] = None
    project: Optional[str] = None
    content: Optional[str] = None
    rating: Optional[int] = None

class Testimonial(TestimonialCreate):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))

# Service Models
class ServiceUpdate(BaseModel):
    description: Optional[str] = None
    technical: Optional[str] = None

class Service(BaseModel):
    id: str
    title: str
    description: str
    technical: str
    order: int

# Company Info Models
class CompanyInfoUpdate(BaseModel):
    slogan: Optional[str] = None
    manifesto: Optional[str] = None
    philosophy: Optional[str] = None
    approach: Optional[str] = None
    excellence_title: Optional[str] = None
    excellence_subtitle: Optional[str] = None
    excellence_description: Optional[str] = None
    mission: Optional[str] = None
    vision: Optional[str] = None
    contact_phone: Optional[str] = None
    contact_email: Optional[str] = None
    contact_address: Optional[str] = None

class CompanyInfo(BaseModel):
    id: str
    slogan: str
    manifesto: str
    philosophy: str
    approach: str
    excellence_title: str
    excellence_subtitle: str
    excellence_description: str
    mission: str
    vision: str
    contact_phone: str
    contact_email: str
    contact_address: str
    updated_at: datetime = Field(default_factory=datetime.utcnow)
