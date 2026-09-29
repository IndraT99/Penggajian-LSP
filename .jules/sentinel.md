## 2024-06-25 - IDOR in PDF Generation Endpoints
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoints returning files.
**Learning:** Even when IDs are obfuscated (e.g., using HashIdRoute), endpoints returning direct object references like PDFs are prone to authorization bypass if ownership and final state checks are omitted, as obfuscated IDs can be leaked or guessed.
**Prevention:** Always implement explicit ownership checks (e.g., `$payroll->employee_id !== $employee->id`) and state validation (e.g., `in_array($payroll->status, ['approved_finance', 'paid'])`) in controller methods, regardless of route model binding obfuscation.
