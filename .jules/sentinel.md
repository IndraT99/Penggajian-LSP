## 2024-05-15 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) in KaryawanSlipGajiController@generatePDF. The endpoint accepted a payroll model ID and generated a PDF without verifying that the payroll belonged to the currently authenticated user.
**Learning:** Endpoints that generate or return files (like PDFs) are frequently overlooked for authorization checks, especially when developers rely on obfuscated IDs (like HashIdRoute) as a primary defense. Route obfuscation is not authorization.
**Prevention:** Always implement explicit ownership checks (e.g., $payroll->employee_id !== Auth::user()->employee->id) and state validations (e.g., check if the document is in a finalized status) on all endpoints, regardless of ID obfuscation mechanisms.
