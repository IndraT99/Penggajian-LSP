## 2025-04-04 - IDOR in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) allowed any employee to download any other employee's salary slip PDF by changing the payroll ID.
**Learning:** Endpoints that generate or download resources directly based on an ID (even if obscured by route model binding or HashIDs) are highly susceptible to IDOR if ownership isn't explicitly validated.
**Prevention:** Always verify that the requested resource belongs to the currently authenticated user before processing or returning it.
