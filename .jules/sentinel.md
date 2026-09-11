## 2024-05-24 - Fix IDOR in Payroll PDF generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint for payrolls. Users could access other employees' slip gaji (pay slips) and draft payrolls by guessing or incrementing the payroll ID in the URL.
**Learning:** Endpoints that generate or return files (like PDFs) are frequently overlooked for authorization checks, as developers focus on the view generation rather than access control.
**Prevention:** Always implement explicit ownership and state/status checks on endpoints returning direct object references, even if obfuscated IDs or file streams are used.
