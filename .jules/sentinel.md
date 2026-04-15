## 2024-03-20 - Fix Insecure Direct Object Reference (IDOR) on PDF Download
**Vulnerability:** Employees could download any employee's PDF slip gaji by manipulating the ID in the URL, as the `generatePDF` endpoint lacked authorization and ownership checks.
**Learning:** Even if an object is accessed directly via route model binding and obfuscated with HashService, explicit authorization and ownership checks must always be implemented, especially for endpoints returning direct object references like files.
**Prevention:** Always verify `$payroll->employee_id === $employee->id` and proper state status before allowing file downloads or direct access to sensitive records.
