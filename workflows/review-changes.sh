#!/bin/bash

# Script para revisar cambios recientes antes de commit
# Autor: Felipe Gaitan
# Fecha: 2025-05-07

# Colores para la salida
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== Revisión de Cambios Recientes ===${NC}\n"

# Verificar si hay cambios sin commit
if [[ -z $(git status -s) ]]; then
    echo -e "${YELLOW}No hay cambios para revisar.${NC}"
    exit 0
fi

# Mostrar archivos modificados
echo -e "${GREEN}Archivos modificados:${NC}"
git status -s

# Función para revisar cambios en un archivo
review_file() {
    local file=$1
    
    if [[ -f "$file" ]]; then
        echo -e "\n${BLUE}=== Revisando: ${file} ===${NC}"
        
        # Determinar el tipo de archivo para aplicar el formato adecuado
        extension="${file##*.}"
        
        case "$extension" in
            php)
                echo -e "${YELLOW}Cambios en PHP:${NC}"
                git diff --color "$file" | cat
                
                # Verificar sintaxis PHP
                echo -e "\n${YELLOW}Verificando sintaxis PHP:${NC}"
                php -l "$file"
                ;;
            js|ts|vue)
                echo -e "${YELLOW}Cambios en JavaScript/TypeScript:${NC}"
                git diff --color "$file" | cat
                ;;
            blade.php)
                echo -e "${YELLOW}Cambios en Blade:${NC}"
                git diff --color "$file" | cat
                ;;
            css|scss)
                echo -e "${YELLOW}Cambios en estilos:${NC}"
                git diff --color "$file" | cat
                ;;
            *)
                echo -e "${YELLOW}Cambios:${NC}"
                git diff --color "$file" | cat
                ;;
        esac
    else
        echo -e "${RED}El archivo $file no existe.${NC}"
    fi
}

# Función para revisar todos los cambios
review_all_changes() {
    echo -e "\n${GREEN}Revisando todos los cambios:${NC}"
    
    # Obtener lista de archivos modificados
    modified_files=$(git status -s | awk '{print $2}')
    
    for file in $modified_files; do
        review_file "$file"
    done
}

# Función para revisar cambios específicos
review_specific_changes() {
    echo -e "\n${GREEN}Seleccione un archivo para revisar:${NC}"
    
    # Listar archivos modificados con números
    modified_files=$(git status -s | awk '{print $2}')
    counter=1
    
    for file in $modified_files; do
        echo -e "${BLUE}$counter${NC}) $file"
        ((counter++))
    done
    
    echo -e "${BLUE}a${NC}) Revisar todos los archivos"
    echo -e "${BLUE}q${NC}) Salir"
    
    read -p "Seleccione una opción: " option
    
    if [[ $option == "q" ]]; then
        exit 0
    elif [[ $option == "a" ]]; then
        review_all_changes
    elif [[ $option =~ ^[0-9]+$ ]] && [ $option -ge 1 ] && [ $option -lt $counter ]; then
        # Obtener el archivo seleccionado
        selected_file=$(echo "$modified_files" | sed -n "${option}p")
        review_file "$selected_file"
    else
        echo -e "${RED}Opción inválida.${NC}"
    fi
}

# Menú principal
show_menu() {
    echo -e "\n${GREEN}Opciones:${NC}"
    echo -e "${BLUE}1${NC}) Revisar todos los cambios"
    echo -e "${BLUE}2${NC}) Seleccionar archivo específico"
    echo -e "${BLUE}3${NC}) Ejecutar linters"
    echo -e "${BLUE}4${NC}) Ejecutar tests"
    echo -e "${BLUE}q${NC}) Salir"
    
    read -p "Seleccione una opción: " option
    
    case $option in
        1)
            review_all_changes
            show_menu
            ;;
        2)
            review_specific_changes
            show_menu
            ;;
        3)
            echo -e "\n${GREEN}Ejecutando linters:${NC}"
            echo -e "${YELLOW}PHP Pint:${NC}"
            ./vendor/bin/pint --test
            
            echo -e "\n${YELLOW}PHPStan:${NC}"
            ./vendor/bin/phpstan analyse
            show_menu
            ;;
        4)
            echo -e "\n${GREEN}Ejecutando tests:${NC}"
            ./vendor/bin/pest
            show_menu
            ;;
        q)
            exit 0
            ;;
        *)
            echo -e "${RED}Opción inválida.${NC}"
            show_menu
            ;;
    esac
}

# Iniciar el script
show_menu
