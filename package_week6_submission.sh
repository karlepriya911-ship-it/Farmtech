#!/usr/bin/env bash
set -euo pipefail

OUTPUT_DIR="WEEK6-SUBMISSION"
ZIP_NAME="FarmTech-Week6-Deployment-Package.zip"
REPORT_FILE="WEEK6-DEPLOYMENT-MAINTENANCE-REFLECTION.md"

mkdir -p "$OUTPUT_DIR"
cp "$REPORT_FILE" "$OUTPUT_DIR/"

cat > "$OUTPUT_DIR/README.txt" <<EOF
FarmTech Week 6 Submission Package
=================================

Contents:
- WEEK6-DEPLOYMENT-MAINTENANCE-REFLECTION.md

This package includes the deployment guide, maintenance documentation,
and project reflection report for the FarmTech application.
EOF

zip -j "$ZIP_NAME" "$OUTPUT_DIR"/*.md "$OUTPUT_DIR"/*.txt

printf '\nCreated archive: %s\n' "$ZIP_NAME"
printf 'If you want to publish it elsewhere, upload the ZIP file generated in the repository root.\n'
