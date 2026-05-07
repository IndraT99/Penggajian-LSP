## 2024-05-24 - IDOR in PDF endpoint
**Vulnerability:** IDOR vulnerability in generating a payroll PDF; any authenticated user could generate/view the PDF of any other user by iterating through payroll IDs.
**Learning:** IDOR can occur even when parameters are passed to models, because route model binding does not perform authorization checks.
**Prevention:** Always check if the resource belongs to the currently authenticated user in methods returning direct objects like PDF.
