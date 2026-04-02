## 2024-05-24 - IDOR in PDF generation endpoint
**Vulnerability:** The endpoint to generate PDF payroll slip (`generatePDF` in `KaryawanSlipGajiController`) accepted a Payroll object directly (via route model binding) but lacked authorization and ownership checks. Any user could potentially download any other user's payroll slip if they knew or could guess the ID.
**Learning:** Even if direct object references are obscured (e.g., via hashing), explicit authorization checks (`$payroll->employee_id === $employee->id`) must still be enforced, especially on endpoints returning sensitive documents like PDF downloads.
**Prevention:** Always verify ownership and appropriate status when exposing objects directly to users, regardless of how the ID is transmitted or obfuscated.
