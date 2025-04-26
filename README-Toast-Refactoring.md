# Toast Notification Refactoring

## Overview
This document outlines the refactoring of toast notifications across the MedVault application to improve code maintainability and reduce redundancy. The refactoring included centralizing toast-related CSS and JavaScript into dedicated files, and updating all relevant PHP files to use these centralized resources.

## Files Created

### 1. CSS File
- **File**: `proj-front/assets/css/toast.css`
- **Purpose**: Contains all styling for toast notifications that was previously duplicated across multiple files.
- **Benefits**: Ensures consistent styling for all toast notifications and simplifies future style updates.

### 2. JavaScript File
- **File**: `proj-front/assets/js/toast.js`
- **Purpose**: Contains the JavaScript functionality for toast notifications (auto-hiding and dismiss button logic).
- **Benefits**: Centralizes event handler logic and ensures consistent behavior across all pages.

## Files Updated

The following files were updated to use the centralized toast resources:

1. `proj-front/includes/header.php`
   - Removed inline toast styles
   - Removed inline toast JavaScript
   - Added links to the new toast CSS and JS files
   - Updated toast container to use the `alertmessage()` function

2. `proj-back/includes/header.php`
   - Removed inline toast styles
   - Removed inline toast JavaScript
   - Added links to the new toast CSS and JS files with relative paths
   - Updated toast container to use the `alertmessage()` function

3. `proj-front/login.php`
   - Added links to the new toast CSS and JS files
   - Removed inline toast rendering code
   - Added a toast container that uses the `alertmessage()` function

4. `index.php`
   - Added links to the new toast CSS and JS files with appropriate paths
   - Removed inline toast styles
   - Updated toast container to use the `alertmessage()` function

## Benefits of Refactoring

1. **Reduced Code Duplication**: Eliminated duplicate toast styles and JavaScript across multiple files.
2. **Improved Maintainability**: Changes to toast styling or behavior now only need to be made in one place.
3. **Consistent User Experience**: Ensures all toast notifications look and behave the same throughout the application.
4. **Smaller File Sizes**: Reduced the size of individual HTML/PHP files by moving common code to separate files.
5. **Better Organization**: Separates presentation (CSS) and behavior (JS) concerns from content (PHP/HTML).

## Future Improvements

Potential future improvements to the toast notification system could include:

1. Adding different toast types (success, warning, error) with appropriate styling
2. Adding the ability to show multiple toasts stacked
3. Implementing a queue system for toast notifications
4. Adding animation options for toast appearance/disappearance 