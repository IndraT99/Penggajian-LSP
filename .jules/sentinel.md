## 2025-03-22 - [Fix IDOR in PDF Download]
**Vulnerability:** IDOR vulnerability allowing unauthorized access to other employees' payroll slips via PDF download, because the controller lacked authorization and status checks.
**Learning:** Even with hashed IDs and route model binding, direct object references for file downloads MUST have explicit authorization checks, as they can bypass the checks present in the `show` method.
**Prevention:** Always ensure that endpoints returning sensitive files or direct object references include the same authorization and status checks as their corresponding view endpoints.
