#!/bin/bash

# Script para configurar git hooks
# Autor: Felipe Gaitan
# Fecha: 2025-05-07

# Colores para la salida
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== Configurando Git Hooks ===${NC}\n"

# Crear directorio .git/hooks si no existe
if [ ! -d ".git/hooks" ]; then
    mkdir -p .git/hooks
    echo -e "${GREEN}Directorio .git/hooks creado.${NC}"
fi

# Crear hook pre-commit
cat > .git/hooks/pre-commit << 'EOF'
#!/bin/bash

# Hook pre-commit para revisar cambios antes de commit
# Autor: Felipe Gaitan
# Fecha: 2025-05-07

# Colores para la salida
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== Pre-Commit: Revisión de Cambios ===${NC}\n"

# Verificar sintaxis PHP
echo -e "${YELLOW}Verificando sintaxis PHP...${NC}"
for file in $(git diff --cached --name-only --diff-filter=ACM | grep -E '\.php$'); do
    # Verificar si el archivo existe (podría haber sido eliminado)
    if [ -f "$file" ]; then
        php -l "$file" > /dev/null 2>&1
        if [ $? -ne 0 ]; then
            echo -e "${RED}Error de sintaxis en $file${NC}"
            php -l "$file"
            exit 1
        fi
    fi
done
echo -e "${GREEN}Sintaxis PHP correcta.${NC}"

# Ejecutar Pint en modo test
if [ -f "./vendor/bin/pint" ]; then
    echo -e "${YELLOW}Verificando estilo de código con Pint...${NC}"
    ./vendor/bin/pint --test > /dev/null 2>&1
    if [ $? -ne 0 ]; then
        echo -e "${RED}El código no cumple con los estándares de estilo.${NC}"
        echo -e "${YELLOW}Ejecuta ./vendor/bin/pint para corregir automáticamente.${NC}"
        echo -e "${YELLOW}O continúa con el commit usando git commit --no-verify${NC}"
        exit 1
    fi
    echo -e "${GREEN}Estilo de código correcto.${NC}"
fi

# Ejecutar PHPStan
if [ -f "./vendor/bin/phpstan" ]; then
    echo -e "${YELLOW}Verificando código con PHPStan...${NC}"
    ./vendor/bin/phpstan analyse --no-progress > /dev/null 2>&1
    if [ $? -ne 0 ]; then
        echo -e "${RED}PHPStan encontró errores en el código.${NC}"
        echo -e "${YELLOW}Ejecuta ./vendor/bin/phpstan analyse para ver los detalles.${NC}"
        echo -e "${YELLOW}O continúa con el commit usando git commit --no-verify${NC}"
        exit 1
    fi
    echo -e "${GREEN}Análisis de PHPStan correcto.${NC}"
fi

# Preguntar si se desea revisar los cambios
echo -e "${YELLOW}¿Deseas revisar los cambios antes de hacer commit? (s/n)${NC}"
read -n 1 -r
echo
if [[ $REPLY =~ ^[Ss]$ ]]; then
    # Ejecutar script de revisión de cambios
    if [ -f "./workflows/review-changes.sh" ]; then
        bash ./workflows/review-changes.sh
    else
        echo -e "${RED}Script de revisión de cambios no encontrado.${NC}"
        echo -e "${YELLOW}Puedes crearlo ejecutando: bash ./workflows/setup-hooks.sh${NC}"
    fi
fi

exit 0
EOF

# Hacer ejecutable el hook pre-commit
chmod +x .git/hooks/pre-commit
echo -e "${GREEN}Hook pre-commit creado y configurado.${NC}"

# Crear hook post-commit
cat > .git/hooks/post-commit << 'EOF'
#!/bin/bash

# Hook post-commit para mostrar resumen después de commit
# Autor: Felipe Gaitan
# Fecha: 2025-05-07

# Colores para la salida
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "\n${BLUE}=== Post-Commit: Resumen de Cambios ===${NC}"

# Mostrar último commit
echo -e "${YELLOW}Último commit:${NC}"
git log -1 --stat

# Mostrar estado actual
echo -e "\n${YELLOW}Estado actual:${NC}"
git status -s

exit 0
EOF

# Hacer ejecutable el hook post-commit
chmod +x .git/hooks/post-commit
echo -e "${GREEN}Hook post-commit creado y configurado.${NC}"

echo -e "\n${GREEN}Configuración de Git Hooks completada.${NC}"
echo -e "${YELLOW}Los hooks se ejecutarán automáticamente en cada operación de Git.${NC}"
echo -e "${YELLOW}Para revisar cambios manualmente, ejecuta: bash ./workflows/review-changes.sh${NC}"
