## 2024-05-24 - [IDOR in PDF Generation]
**Vulnerability:** Insecure Direct Object Reference (IDOR) allowed any authenticated user to download any other employee's salary slip PDF by changing the payroll ID in the URL.
**Learning:** Even if an object is accessed directly via route model binding and the URL is somewhat obfuscated, endpoints returning direct object references (like PDF downloads) must always explicitly check authorization and ownership against the authenticated user.
**Prevention:** Always implement explicit ownership checks (`if ($payroll->employee_id !== $employee->id)`) and state checks (`in_array($payroll->status, ['approved_finance', 'paid'])`) on endpoints, particularly those returning direct object references.
