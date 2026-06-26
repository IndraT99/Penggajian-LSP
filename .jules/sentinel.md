## 2024-06-26 - IDOR in generatePDF
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation. The `generatePDF` method accepted a `Payroll` object directly without checking if it belonged to the authenticated user.
**Learning:** Route model binding does not perform authorization. When an object is injected, an attacker could change the route ID and access other users' data, especially files or PDFs.
**Prevention:** Always verify ownership (`$model->owner_id === $authenticatedUser->id`) and state (`in_array($model->status, ['finalized'])`) before rendering or returning sensitive files.
