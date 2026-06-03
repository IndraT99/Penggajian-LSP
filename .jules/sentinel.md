## 2024-06-03 - [Fix IDOR in PDF Generation]
**Vulnerability:** The PDF generation endpoint for payroll slips in `KaryawanSlipGajiController::generatePDF` lacked authorization checks, allowing any authenticated user to download any other user's payroll slip by ID.
**Learning:** Endpoints that generate or return files (like PDFs) are frequently overlooked for authorization checks, as developers focus on the view generation logic rather than access control, especially when route model binding is used.
**Prevention:** Always explicitly check ownership and authorization (e.g., `employee_id` matching authenticated user) and entity state (e.g., `status`) in endpoints that return direct object references, including file downloads.
