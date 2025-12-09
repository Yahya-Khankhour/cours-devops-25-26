#!/bin/bash
echo "🚀 Starting PHP ArticlesApp Quality Checks..."
echo "=============================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to check command success
check_status() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ $1${NC}"
        return 0
    else
        echo -e "${RED}✗ $1${NC}"
        return 1
    fi
}

echo -e "\n${YELLOW}1. Checking PHP Syntax...${NC}"
echo "--------------------------------"
for file in $(find src -name "*.php"); do
    php -l "$file"
    check_status "Syntax check: $file"
done

echo -e "\n${YELLOW}2. Running PHP Code Sniffer (PSR-12)...${NC}"
echo "-----------------------------------------------"
if command -v phpcs &> /dev/null; then
    phpcs --standard=PSR12 src/
    check_status "PHP Code Sniffer"
else
    echo "PHP Code Sniffer not installed, skipping..."
fi

echo -e "\n${YELLOW}3. Running PHP Mess Detector...${NC}"
echo "----------------------------------------"
if command -v phpmd &> /dev/null; then
    phpmd src text cleancode,codesize,controversial,design,naming,unusedcode
    check_status "PHP Mess Detector"
else
    echo "PHPMD not installed, skipping..."
fi

echo -e "\n${YELLOW}4. Running PHP Copy/Paste Detector...${NC}"
echo "----------------------------------------------"
if command -v phpcpd &> /dev/null; then
    phpcpd src/
    check_status "PHP Copy/Paste Detector"
else
    echo "PHPCPD not installed, skipping..."
fi

echo -e "\n${YELLOW}5. Running PHPStan Static Analysis...${NC}"
echo "---------------------------------------------"
if command -v phpstan &> /dev/null; then
    phpstan analyse src --level=5
    check_status "PHPStan Analysis"
else
    echo "PHPStan not installed, skipping..."
fi

echo -e "\n${YELLOW}6. Running Unit Tests with PHPUnit...${NC}"
echo "----------------------------------------------"
if command -v phpunit &> /dev/null; then
    phpunit --bootstrap tests/bootstrap.php tests/
    check_status "PHPUnit Tests"
else
    echo "PHPUnit not installed, running with composer..."
    composer test
fi

echo -e "\n${YELLOW}7. Checking Composer Dependencies...${NC}"
echo "---------------------------------------------"
if [ -f "composer.json" ]; then
    composer validate
    check_status "Composer validation"
    
    composer outdated --direct
    check_status "Outdated dependencies check"
fi

echo -e "\n=============================================="
echo -e "${GREEN}✅ All quality checks completed!${NC}"