## 2024-05-05 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) in `KaryawanSlipGajiController@generatePDF`.
**Learning:** Endpoints that generate files (like PDFs) using route model binding must implement explicit ownership checks, as they often bypass the standard view authorization logic.
**Prevention:** Always verify the authenticated user's ownership of the requested resource (e.g., `$payroll->employee_id !== $employee->id`) before processing sensitive actions, even if the route ID is obfuscated.
