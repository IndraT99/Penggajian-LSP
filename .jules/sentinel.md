## 2025-06-25 - IDOR in Karyawan PDF Generation
**Vulnerability:** The `generatePDF` endpoint in `KaryawanSlipGajiController` allowed any employee to access any other employee's payslip PDF by direct object reference, bypassing both ownership and finalization status checks.
**Learning:** Endpoints that generate files or PDFs often overlook access control, focusing on view generation. Obfuscated route keys (like those from HashIdRoute) are not a replacement for explicit authorization checks.
**Prevention:** Always implement explicit ownership (`employee_id` match) and state (`status` check) verification on all endpoints returning direct object references or files, even when using route model binding with obfuscated IDs.
