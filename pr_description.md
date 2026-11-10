🚨 Severity: HIGH
💡 Vulnerability: IDOR in `KaryawanSlipGajiController@generatePDF` allowed any authenticated user to download any other user's payroll slip PDF by guessing the payroll ID/hash.
🎯 Impact: This could allow unauthorized access to sensitive payroll and salary information of other employees, leading to privacy violations and potential internal conflict.
🔧 Fix: Added explicit ownership check (`$payroll->employee_id !== $employee->id`) and status verification (`approved_finance` or `paid`) directly inside the `generatePDF` controller method before rendering the PDF.
✅ Verification: Ensure the test suite continues to run (passing other than expected redirects). To verify the IDOR manually, attempt to download a payroll PDF using another employee's account; it should now correctly return a 403 Forbidden.
