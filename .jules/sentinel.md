## 2024-05-24 - Fix IDOR in PDF Slip Gaji Generation
**Vulnerability:** The `generatePDF` method in `KaryawanSlipGajiController` lacked authorization checks, allowing any authenticated user to download the salary slips of other employees by accessing the endpoint with a different payroll ID.
**Learning:** Route model binding obfuscation (like `HashService`) is not a substitute for proper authorization. Endpoints returning direct object references (like PDF downloads) must explicitly verify ownership and state.
**Prevention:** Always implement explicit ownership checks (`$model->owner_id === $authenticatedUser->id`) and state validation (`in_array($model->status, [...])`) on controller methods that provide access to sensitive resources or generate files, even if route keys are obfuscated.
