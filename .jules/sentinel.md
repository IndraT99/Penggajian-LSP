## 2024-05-18 - Fix IDOR in Payroll PDF generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint `KaryawanSlipGajiController@generatePDF`.
**Learning:** Endpoints returning files or generated documents often miss authorization checks, exposing sensitive information. Obfuscated route keys (HashIdRoute) do not provide authorization and do not prevent IDOR. State/status of resources needs to be checked along with ownership.
**Prevention:** Always implement explicit authorization and state checks (e.g. `$payroll->employee_id === $employee->id` and status `approved_finance` / `paid`) on direct object references, regardless of whether the ID is obfuscated.
