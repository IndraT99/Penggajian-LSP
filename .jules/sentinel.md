## 2024-05-18 - Fix IDOR in KaryawanSlipGajiController@generatePDF
**Vulnerability:** IDOR in PDF generation endpoint allowing any authenticated user to download any other user's salary slip by ID.
**Learning:** Endpoints that generate or serve files (like PDFs) that accept models directly are particularly susceptible to IDOR if they don't have explicit ownership and state checks, since developers often focus on the file generation rather than access control.
**Prevention:** Always implement explicit ownership checks (`$model->user_id === Auth::id()`) and necessary state checks (e.g., status is finalized) on endpoints returning direct object references or files, even if route model binding is obfuscated.
