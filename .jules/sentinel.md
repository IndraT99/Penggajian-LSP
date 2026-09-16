## 2024-05-18 - IDOR in PDF Generation
**Vulnerability:** Insecure Direct Object Reference (IDOR) on PDF download endpoint (`/karyawan/slip-gaji/{payroll}/pdf`)
**Learning:** Endpoints that generate or return files (like PDFs) using obfuscated IDs/hashes often miss ownership and state validation checks because developers assume the hash is unguessable or focus entirely on the view generation. Route model binding combined with obfuscation can lead to a false sense of security.
**Prevention:** Always implement explicit ownership checks (`$model->owner_id === $currentUser->id`) and state checks (e.g., ensuring draft/unapproved documents aren't accessible) on all endpoints, especially those generating files or directly returning object data, regardless of how IDs are obfuscated in the route.
