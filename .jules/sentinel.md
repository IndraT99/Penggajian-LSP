## 2024-05-24 - [IDOR in PDF Generation]
**Vulnerability:** IDOR in `KaryawanSlipGajiController@generatePDF` where a user could download any payroll PDF by manipulating the payroll ID due to missing authorization checks in the route handler.
**Learning:** Endpoints that generate files (like PDFs) or return direct references are just as susceptible to IDOR as data-returning endpoints, and route obfuscation (if present) does not replace actual authorization.
**Prevention:** Always verify object ownership against the authenticated user and validate the object's state (e.g. status) in controller methods handling route model binding, especially for file generation.
