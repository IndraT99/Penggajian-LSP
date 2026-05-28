## 2024-05-28 - IDOR in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation route (`/karyawan/slip-gaji/{payroll}/pdf`). The controller generated and returned PDFs based on a hashed ID without checking if the authenticated employee owned the requested payroll record or if the record was in a finalized state.
**Learning:** Route model binding and obfuscated IDs do not replace authorization. Endpoints that return files (like PDFs) are often overlooked for access control because developers focus on view rendering rather than authorization.
**Prevention:** Always implement explicit ownership (`$model->user_id === Auth::id()`) and state checks (`status === 'approved_finance'`) on all endpoints returning direct object references or files.
