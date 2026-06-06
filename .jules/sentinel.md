## 2025-02-18 - Missing Authorization in PDF Generation Endpoints
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF download endpoints (e.g., `generatePDF`), allowing unauthorized access to other users' sensitive documents or unfinalized data.
**Learning:** Route model binding and obfuscated IDs (`HashService`) do not provide authorization. Developers often overlook explicit ownership and status checks on utility/export endpoints compared to standard view methods.
**Prevention:** Always enforce explicit ownership and state checks on endpoints returning direct object references or files, matching the authorization logic used in standard display methods.
