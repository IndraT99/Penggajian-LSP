
## 2025-01-24 - Fix IDOR in PDF generation endpoint
**Vulnerability:** The generatePDF endpoint allowed any authenticated user to download any other user's salary slip by referencing the object ID, bypassing authorization checks.
**Learning:** Even when using route model binding with potentially obfuscated IDs, always explicitly check authorization and ownership on endpoints that return direct object references.
**Prevention:** Always verify ownership ($payroll->employee_id === $authenticatedUser->id) and state before returning sensitive files or data.
