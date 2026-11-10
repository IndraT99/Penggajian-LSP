## 2024-05-24 - Fix IDOR in Payroll PDF Generation
**Vulnerability:** IDOR in `KaryawanSlipGajiController@generatePDF` allowed any authenticated user to download any other user's payroll slip PDF by guessing the payroll ID/hash.
**Learning:** Endpoints that generate or return files (like PDFs) using direct object references (e.g., via Route Model Binding) frequently miss authorization checks because the developer's focus is on the file generation logic rather than access control.
**Prevention:** Always explicitly check object ownership and status (e.g., against the authenticated user's employee record) at the very beginning of any controller method that accepts a model instance directly from the route, especially for file downloads or exports.
