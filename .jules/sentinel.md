## 2025-03-30 - Insecure Direct Object Reference (IDOR) on PDF Download
**Vulnerability:** The route `karyawan.slip-gaji.pdf` which downloads the PDF of a payroll allowed any authenticated user to download any payroll slip because it lacked ownership verification and status validation checks on the retrieved model.
**Learning:** Even when using route model binding with hashed IDs (which slightly obfuscates IDs), direct object reference routes still require explicit authorization checks ensuring the object belongs to the authenticated user and is in a valid state to be accessed.
**Prevention:** Always verify object ownership (`$model->user_id === Auth::id()`) inside controller methods when returning direct resources, and do not rely on ID obfuscation as a security boundary.
