# 📌 Módulo Personalizado para Drupal 11.1.2

Este repositorio contiene un **módulo personalizado** desarrollado en **Drupal 11.1.2**, junto con la carpeta `themes`, la carpeta `sites` y la base de datos usada en el proyecto.

## 📂 **Estructura del Repositorio**
El repositorio incluye las siguientes carpetas:

- **`modules/custom/`** → Contiene el módulo personalizado desarrollado.
- **`themes/`** → Contiene los temas utilizados en el proyecto.
- **`sites/`** → Configuración y archivos del sitio de Drupal.
- **`database/`** → Copia de la base de datos usada en el proyecto.
- - **`src/`** → con los controladores necesarios.

---

## 📌 **Requisitos del Proyecto**
Para utilizar este proyecto, necesitas tener instalado:
composer create-project drupal/recommended-project drupal-11.1.2
cd drupal-11.1.2
Ahora, copia las carpetas del repositorio en la estructura de Drupal:
cp -r ../tu-repositorio/modules custom/
cp -r ../tu-repositorio/themes themes/
cp -r ../tu-repositorio/sites sites/
Si subiste la base de datos, impórtala en MySQL:
Asegúrate de actualizar los datos de conexión

Después de la configuración, activa el módulo personalizado desde la línea de comandos
Para verificar que el módulo funciona correctamente, accede a la URL donde se muestra el contenido:
https://tu-sitio.com/custom/users-list/search


- **PHP 8.2 o superior**
- **Composer**
- **MySQL / MariaDB**
- **Apache / Nginx**
- **Drupal 11.1.2**
- **Drush (opcional, pero recomendado)**

---

## 🚀 **Instalación y Configuración**
Sigue estos pasos para configurar el proyecto en tu entorno local:

### 1️⃣ **Clonar el Repositorio**
```bash
git clone https://github.com/tu-usuario/tu-repositorio.git
cd tu-repositorio
