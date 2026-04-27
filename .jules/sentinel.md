## 2026-04-27 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) found in KaryawanSlipGajiController's generatePDF method. Users could generate and download payroll PDFs of other employees by guessing obfuscated route IDs, because ownership checks were missing on the PDF generation route.
**Learning:** Obfuscation (like HashService) is not authorization. Any endpoint returning direct object references or sensitive files (like PDFs) MUST explicitly check authorization and ownership, regardless of whether the ID is hashed in the route.
**Prevention:** Always implement explicit ownership checks ($payroll->employee_id === auth()->user()->employee->id) and state checks (status = approved_finance/paid) on endpoints accessed by employees.
