
## 2024-05-24 - [Fix IDOR in KaryawanSlipGajiController generatePDF]
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint `KaryawanSlipGajiController@generatePDF`. An authenticated user could download any employee's payroll slip by changing the payroll ID. It also allowed downloading unapproved/draft payrolls.
**Learning:** Endpoints that generate or return files (e.g. PDFs) often use route model binding but developers sometimes forget to add authorization checks, assuming obscurity of the ID or relying on the view layer to hide the link. State/status validation is also needed.
**Prevention:** Always verify explicit ownership (`$model->employee_id === Auth::user()->employee->id`) and state (`$model->status` is finalized) on endpoints returning direct object references, even if accessed via obfuscated route IDs or simple file downloads.
