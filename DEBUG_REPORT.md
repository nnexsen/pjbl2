# Web Sekolah - Code Debug Report

## Critical Issues Found

### 1. **SQL INJECTION VULNERABILITY** 🔴 CRITICAL
**Files Affected:**
- `edit_profil.php` (Lines 16, 18)
- `tambah_galeri.php` (Lines 17-25)
- `index.php` (Line 15) - DUPLICATE ISSUE WITH login.php

**Issue:** Direct string concatenation in SQL queries instead of prepared statements.

**Examples:**
```php
// BAD - edit_profil.php:16
mysqli_query($conn, "UPDATE profil SET nama_sekolah='$n', alamat='$a', logo='$n_logo', visi='$v', misi='$m', sejarah='$s' WHERE id=1");

// BAD - tambah_galeri.php:17-25
mysqli_query($conn, "INSERT INTO galeri VALUES('', '$judul', '$gambar', '$deskripsi', NOW())");
```

**Risk:** Attackers can inject malicious SQL code through form inputs to steal/modify/delete data.

**Fix:** Use prepared statements with parameter binding (like login.php correctly does).

---

### 2. **DUPLICATE LOGIN CODE** 🟡 MEDIUM
**Files:** `index.php` (Lines 9-39) and `login.php` (Lines 1-41)

**Issue:** Both files have login functionality with different approaches:
- `index.php` uses raw SQL injection vulnerable code (Line 15)
- `login.php` correctly uses prepared statements

**Decision Needed:** Which is the actual login page? Both need consistent security.

---

### 3. **MISSING SESSION START** 🟡 MEDIUM
**Files Affected:**
- `tambah_berita.php` (Line 2)
- `tambah_galeri.php` (Line 1)
- `edit_profil.php` (Line 1)
- `galeri.php` (Line 1)
- `seluruh_berita.php` (Line 2)
- `baca.php` (Line 1)

**Issue:** These files require `$_SESSION` (koneksi.php needs it, they include koneksi.php) but never call `session_start()`.

**Current koneksi.php:**
```php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
```

**Problem:** koneksi.php is supposed to start the session, but some files don't include it early enough, or koneksi.php needs to be included at the very top.

**Recommendation:** Add `require 'koneksi.php';` as the absolute first line in all PHP files.

---

### 4. **INCONSISTENT SESSION VARIABLE NAMES** 🟡 MEDIUM
**Issue:** Login uses different session keys:
- `index.php` Line 24: `$_SESSION['login'] = true;`
- `login.php` Line 25: `$_SESSION['admin'] = $username;`

**Problem:** 
- `dashboard.php` checks for `$_SESSION['admin']`
- Some pages check for `$_SESSION['login']`
- This inconsistency causes authorization bypass/confusion

**Fix:** Use consistent session variable naming (suggest `$_SESSION['admin']` everywhere).

---

### 5. **INSECURE FILE UPLOAD (No Validation)** 🔴 CRITICAL
**Files Affected:**
- `dashboard.php` (Lines 99-163)
- `edit_berita.php` (Lines 30-40)
- `edit_galeri.php` (Lines 65-76)
- `edit_profil.php` (Lines 11-15)
- `tambah_berita.php` (Lines 7-10)
- `tambah_galeri.php` (Lines 9-14)

**Issues:**
1. No file type validation (accept any file type)
2. No file size validation
3. No filename sanitization (rename only with timestamp)
4. `move_uploaded_file()` with no error checking

**Risks:**
- Users can upload malicious .php files and execute code
- DoS attacks with huge files
- Directory traversal attacks

**Minimal Fix:** Check file extension
```php
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
$ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) die('Invalid file type');
```

---

### 6. **XSS (Cross-Site Scripting) VULNERABILITY** 🔴 CRITICAL
**Files Affected:**
- `baca.php` (Lines 32, 34)
- `index.php` (Lines 95-97)
- `galeri.php` (Lines 25, 27, 29)
- `seluruh_berita.php` (Lines 84, 89-93)
- `dashboard.php` (Lines 320, 341, 436, 441)
- `edit_berita.php` (Lines 61-62)

**Issue:** User data echoed directly without HTML escaping.

**Example:**
```php
// BAD - baca.php:32
<h1><?= $berita['judul'] ?></h1>

// BAD - baca.php:34
<p><?= nl2br($berita['isi']) ?></p>
```

**Risk:** If judul/isi contains `<script>alert('hacked')</script>`, it executes on page load.

**Fix:** Use `htmlspecialchars()`:
```php
<h1><?= htmlspecialchars($berita['judul'], ENT_QUOTES, 'UTF-8') ?></h1>
<p><?= nl2br(htmlspecialchars($berita['isi'], ENT_QUOTES, 'UTF-8')) ?></p>
```

---

### 7. **MISSING ERROR CHECKING** 🟡 MEDIUM
**Files:** All database operations

**Issue:** No error checking on:
- `mysqli_query()` return values
- `move_uploaded_file()` success
- `unlink()` file deletion

**Example:**
```php
// NO ERROR CHECK
move_uploaded_file($_FILES['gambar']['tmp_name'], "assets/uploads/" . $img);
```

**Fix:**
```php
if (!move_uploaded_file($_FILES['gambar']['tmp_name'], "assets/uploads/" . $img)) {
    die('File upload failed');
}
```

---

### 8. **INCOMPLETE HTML** 🟡 MEDIUM
**Files Affected:**
- `tambah_berita.php` (Line 50: Missing closing `</html>` tag)
- `login.php` (Line 64: Missing closing `</html>` tag)

**Issue:** HTML document is not properly closed.

**Fix:** Add `</html>` at the end.

---

### 9. **MISSING AUTHENTICATION CHECK** 🟡 MEDIUM
**Files:**
- `tambah_berita.php` (Line 2)
- `tambah_galeri.php` (Line 1)

**Issue:** Pages don't check if user is logged in as admin.

**Current:** `edit_berita.php` correctly checks: `if (!isset($_SESSION['admin'])) header("Location: login.php");`

**Fix:** Add same check to tambah_berita.php and tambah_galeri.php.

---

### 10. **NAVIGATION LINK ISSUES** 🟡 MINOR
**Files:**
- `tambah_berita.php` Line 31: Links to `berita.php` (doesn't exist, should be `dashboard.php`)
- `edit_profil.php` Line 33: Links to `berita.php` (doesn't exist)

**Fix:** Change to `dashboard.php`.

---

## Summary Table

| Issue | Severity | Files | Type |
|-------|----------|-------|------|
| SQL Injection | CRITICAL | edit_profil.php, tambah_galeri.php | Security |
| Duplicate Login Logic | MEDIUM | index.php, login.php | Architecture |
| Missing Session Start | MEDIUM | Multiple | Logic |
| Inconsistent Session Keys | MEDIUM | Multiple | Logic |
| Insecure File Upload | CRITICAL | 6 files | Security |
| XSS Vulnerability | CRITICAL | 6+ files | Security |
| Missing Error Checking | MEDIUM | All | Code Quality |
| Incomplete HTML | MEDIUM | 2 files | Code Quality |
| Missing Auth Check | MEDIUM | 2 files | Security |
| Navigation Issues | MINOR | 2 files | Bug |

---

## Priority Fixes

### Phase 1 (CRITICAL - Do First)
1. [ ] Fix SQL injection in `edit_profil.php` and `tambah_galeri.php`
2. [ ] Add XSS protection with `htmlspecialchars()`
3. [ ] Add file type validation for uploads

### Phase 2 (MEDIUM - Do Next)
1. [ ] Consolidate login logic (remove duplication)
2. [ ] Standardize session variable names
3. [ ] Add missing session_start() or ensure koneksi.php is included first
4. [ ] Add error checking to file operations

### Phase 3 (MINOR - Polish)
1. [ ] Fix incomplete HTML tags
2. [ ] Fix navigation links
3. [ ] Add missing authentication checks

---

## Quick Reference: File Security Status

✅ **Secure:**
- `koneksi.php` - Uses proper session handling
- `login.php` - Uses prepared statements
- `logout.php` - Simple and safe

⚠️ **Needs Fixes:**
- `index.php` - SQL injection, login duplication, XSS
- `dashboard.php` - No file validation, some XSS issues
- `edit_berita.php` - XSS, no file validation
- `edit_galeri.php` - No file validation
- `edit_profil.php` - SQL injection, no file validation
- `baca.php` - XSS
- `galeri.php` - XSS
- `seluruh_berita.php` - XSS
- `tambah_berita.php` - No auth check, XSS, no file validation, missing HTML
- `tambah_galeri.php` - SQL injection, no auth check, XSS, incomplete HTML

---

## Database Assumptions

This report assumes the following database structure exists:
- `admin` table with `username` and `password` columns
- `berita` table with `id`, `judul`, `isi`, `gambar` columns
- `galeri` table with `id`, `judul`, `gambar`, `deskripsi`, `tanggal_upload` columns
- `profil` table with `id`, `nama_sekolah`, `alamat`, `logo`, `visi`, `misi`, `sejarah` columns
