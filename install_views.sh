#!/bin/bash

# ====================================
# QUICK INSTALLATION SCRIPT
# Sistem Permohonan Informasi Publik
# ====================================

echo "🚀 Installing Information Request System Views..."
echo ""

# Create directories
echo "📁 Creating directories..."
mkdir -p resources/views/public/information
mkdir -p resources/views/admin/information/flows
mkdir -p resources/views/admin/information/requests

echo "✅ Directories created!"
echo ""

# Copy Public Views
echo "📋 Copying Public Views..."
cp public_information_flow_view.blade.php resources/views/public/information/flow.blade.php
cp public_information_create_view.blade.php resources/views/public/information/create.blade.php
cp public_information_tracking_view.blade.php resources/views/public/information/tracking.blade.php

echo "✅ Public views copied!"
echo ""

# Copy Admin Flow Views
echo "📋 Copying Admin Flow Views..."
cp admin_information_flows_index.blade.php resources/views/admin/information/flows/index.blade.php
cp admin_information_flows_form.blade.php resources/views/admin/information/flows/create.blade.php
cp admin_information_flows_form.blade.php resources/views/admin/information/flows/edit.blade.php

echo "✅ Admin flow views copied!"
echo ""

# Copy Admin Request Views
echo "📋 Copying Admin Request Views..."
cp admin_information_requests_index.blade.php resources/views/admin/information/requests/index.blade.php
cp admin_information_requests_show.blade.php resources/views/admin/information/requests/show.blade.php

echo "✅ Admin request views copied!"
echo ""

# Verify installation
echo "🔍 Verifying installation..."
echo ""

PUBLIC_COUNT=$(find resources/views/public/information -name "*.blade.php" 2>/dev/null | wc -l)
ADMIN_FLOW_COUNT=$(find resources/views/admin/information/flows -name "*.blade.php" 2>/dev/null | wc -l)
ADMIN_REQUEST_COUNT=$(find resources/views/admin/information/requests -name "*.blade.php" 2>/dev/null | wc -l)

echo "📊 Installation Summary:"
echo "   - Public Views: $PUBLIC_COUNT files"
echo "   - Admin Flow Views: $ADMIN_FLOW_COUNT files"
echo "   - Admin Request Views: $ADMIN_REQUEST_COUNT files"
echo ""

TOTAL=$((PUBLIC_COUNT + ADMIN_FLOW_COUNT + ADMIN_REQUEST_COUNT))
echo "   Total: $TOTAL files installed"
echo ""

# Clear caches
echo "🧹 Clearing Laravel caches..."
php artisan view:clear
php artisan cache:clear

echo "✅ Caches cleared!"
echo ""

# Final message
echo "============================================"
echo "✨ Installation Complete!"
echo "============================================"
echo ""
echo "📝 Next Steps:"
echo "   1. Verify routes in routes/web.php"
echo "   2. Test public routes:"
echo "      - /permohonan-informasi"
echo "      - /permohonan-informasi/ajukan"
echo "      - /permohonan-informasi/lacak"
echo ""
echo "   3. Test admin routes:"
echo "      - /admin/information-flows"
echo "      - /admin/information-requests"
echo ""
echo "   4. Check VIEWS_COMPLETE_GUIDE.md for details"
echo ""
echo "Happy coding! 🚀"
