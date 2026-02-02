# Upgrade Guide

## Upgrading Event Registration Module

This document provides instructions for upgrading the Event Registration Module to newer versions.

## 📋 Prerequisites

Before upgrading, ensure you have:

- ✅ **Backup**: Complete backup of your database and files
- ✅ **Testing Environment**: Test upgrade in a staging environment first
- ✅ **Drupal Compatibility**: Verify compatibility with your Drupal version
- ✅ **PHP Compatibility**: Check PHP version requirements
- ✅ **Dependencies**: Ensure all required modules are compatible
- ✅ **Customizations**: Document any custom modifications

## 🔄 General Upgrade Process

### 1. **Pre-Upgrade Steps**

```bash
# 1. Backup your site
drush sql-dump > backup.sql
tar -czf files-backup.tar.gz sites/default/files/

# 2. Disable the module (if needed)
drush pm-uninstall event_registration

# 3. Remove old module files
rm -rf modules/custom/event_registration/
2. Installation Steps
# 1. Download new version
# Option A: Download from GitHub releases
wget https://github.com/your-username/event-registration/releases/latest/download/event_registration.zip

# Option B: Clone from repository
git clone https://github.com/your-username/event-registration.git modules/custom/event_registration

# 2. Extract/copy to modules directory
unzip event_registration.zip -d modules/custom/
3. Post-Upgrade Steps
# 1. Enable the module
drush en event_registration

# 2. Run database updates
drush updatedb

# 3. Clear all caches
drush cr

# 4. Rebuild registry (if needed)
drush rr