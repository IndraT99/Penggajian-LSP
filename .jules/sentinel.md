## 2025-02-05 - IDOR in PDF Generation Endpoint
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint for payroll slips.
**Learning:** Endpoints that return files or PDFs often overlook access control, assuming obfuscated IDs (like `HashService`) or route model bindings are sufficient. Developers may focus solely on view generation rather than authorization.
**Prevention:** Always implement explicit ownership checks (`employee_id` vs authenticated `user_id`) and status validations (`approved_finance` or `paid`) even if route IDs are obfuscated.
