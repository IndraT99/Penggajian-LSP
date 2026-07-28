## 2024-07-28 - IDOR in Payroll PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on the PDF generation route. Users could generate PDFs for any payroll record, including those belonging to other employees or draft payrolls, simply by modifying the ID.
**Learning:** Endpoints that generate documents or files (like PDFs) are often overlooked for access control. Developers might focus purely on the view generation logic and assume the route isn't vulnerable because the ID is obfuscated.
**Prevention:** Always implement explicit ownership checks (`employee_id` vs authenticated user) and state checks (`status` is final) on endpoints that return direct object references, regardless of route model binding or ID obfuscation techniques.
