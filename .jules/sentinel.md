## 2024-03-29 - Missing IDOR Check on PDF Export
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint for payroll slips.
**Learning:** Endpoints that export documents (like PDFs) using route model binding can be accessed directly, bypassing listing view protections.
**Prevention:** Always verify ownership and authorization directly in export controllers before rendering output, regardless of how the route is accessed.
