## 2025-05-21 - Fix IDOR in PDF Generation
**Vulnerability:** An Insecure Direct Object Reference (IDOR) was found in `KaryawanSlipGajiController@generatePDF`. Employees could download PDF slips for other employees if they knew the payroll ID.
**Learning:** Endpoints that generate files (like PDFs) or perform direct downloads often bypass normal view-level authorization checks. Always ensure that authorization and ownership checks are explicitly performed before generating/serving the file.
**Prevention:** Implement strict ownership and status checks (e.g., `approved_finance`, `paid`) at the beginning of controller methods handling direct object references and downloads.
