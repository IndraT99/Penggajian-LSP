
## 2024-05-18 - Prevent IDOR on file/PDF endpoints
**Vulnerability:** IDOR vulnerability in `KaryawanSlipGajiController::generatePDF`. Users could generate and view PDFs of other employees' salary slips by guessing the Payroll ID. Additionally, they could download draft slips before final approval.
**Learning:** Endpoints that generate files (like PDFs) are often overlooked for authorization checks, as developers focus on the view generation rather than access control. Using obfuscated IDs is not sufficient security. State checks are also critical to prevent access to unfinalized data.
**Prevention:** Always implement explicit ownership (`$model->owner_id === Auth::user()->id`) and state checks (`in_array($model->status, ['final', 'approved'])`) on endpoints returning direct object references or files, even if IDs are obfuscated.
