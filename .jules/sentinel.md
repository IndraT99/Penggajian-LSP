## 2024-10-24 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint for salary slips, allowing authenticated employees to iterate payroll IDs and download slips belonging to others.
**Learning:** Endpoints handling file generation (like `Barryvdh\DomPDF\Facade\Pdf`) often overlook authorization checks because the focus is on generating the view. Direct object binding doesn't guarantee ownership.
**Prevention:** Always verify object ownership (e.g., `employee_id` matches authenticated user) and object state (`status`) before generating or returning sensitive files, even if the route uses route model binding or obfuscated IDs.
