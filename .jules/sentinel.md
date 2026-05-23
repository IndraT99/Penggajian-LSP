## 2024-05-23 - IDOR in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint. Any authenticated user could download any other user's salary slip by enumerating the payroll ID.
**Learning:** Laravel's route model binding obfuscates IDs but does not perform authorization. Endpoints returning files (like PDF downloads) often bypass standard view-level checks and need explicit ownership validation.
**Prevention:** Always verify ownership (`$model->user_id === auth()->id()` or equivalent) and state (e.g., status == 'approved') on controller methods that return files or direct object references, even if the route ID is obfuscated.
