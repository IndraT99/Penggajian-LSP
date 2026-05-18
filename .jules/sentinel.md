## 2024-05-18 - Missing Authorization in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF generation endpoint.
**Learning:** Obfuscating IDs (HashIds) does not replace the need for explicit ownership checks, especially on export endpoints like PDF generation.
**Prevention:** Always verify `$model->user_id === Auth::id()` (or equivalent ownership) on endpoints returning direct object references, regardless of route key obfuscation.
