## 2025-02-12 - Missing Ownership and Status Checks in PDF Generation Endpoints
**Vulnerability:** IDOR (Insecure Direct Object Reference) in `KaryawanSlipGajiController@generatePDF` where a user could download any payroll slip without ownership or status validation.
**Learning:** Endpoints that bypass regular views and directly return files or PDFs often overlook the standard authorization checks present in web view endpoints, despite taking similar route parameters.
**Prevention:** Ensure that all endpoints utilizing route model binding, especially those returning files or performing actions, explicitly validate resource ownership and necessary state conditions matching the authenticated user.
