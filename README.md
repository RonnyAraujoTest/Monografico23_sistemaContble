# Monografico23_sistemaContble

🎓 Sistema de Gestión Educativa (SICOLAR)

📌 Descripción

SICOLAR es una aplicación web desarrollada para la gestión administrativa de un centro educativo.  
Su objetivo principal es centralizar y optimizar procesos como el manejo de estudiantes, empleados, pagos, nómina y prestaciones laborales.

El sistema permite una administración más organizada, reduciendo errores y mejorando la eficiencia en el control de la información.


🎯 Objetivo

Desarrollar una solución tecnológica que permita:

- Automatizar procesos administrativos
- Mejorar la organización de los datos
- Facilitar la gestión académica y financiera
- Reducir el uso de métodos manuales



 🧠 Problemática

Muchos centros educativos gestionan sus procesos de forma manual o con herramientas no integradas, lo que genera:

- Pérdida de información
- Desorganización de datos
- Dificultad en el control financiero
- Errores en cálculos de pagos y nómina

Este sistema surge como una solución a estas necesidades.


⚙️ Tecnologías Utilizadas

- PHP → Lógica del sistema  
- MySQL → Base de datos  
- HTML5 → Estructura  
- CSS3 → Diseño y estilos  
- JavaScript → Interactividad  
- Chart.js → Visualización de datos  



 🧩 Módulos del Sistema

📊 Dashboard
- Visualización general del sistema
- Estadísticas de estudiantes, empleados y pagos
- Gráficos informativos

👨‍🎓 Gestión de Estudiantes
- Registro de estudiantes
- Edición y consulta de datos
- Asignación de cursos
- Control de estado (activo/inactivo)

👨‍💼 Gestión de Empleados
- Registro de empleados
- Asignación automática de salario según cargo
- Control de información personal y laboral



💰 Módulo de Pagos
- Registro de pagos de estudiantes
- Control financiero básico
- Almacenamiento de historial de pagos

🧾 Módulo de Nómina
- Cálculo automático de salarios
- Deducciones:
  - AFP
  - SFS
  - ISR
- Generación del salario neto

 💼 Módulo de Prestaciones
- Cálculo de:
  - Preaviso
  - Cesantía
  - Vacaciones
  - Regalía pascual

📁 Historial
- Registro de movimientos del sistema
- Seguimiento de acciones realizadas

 🗄️ Base de Datos

El sistema utiliza MySQL para almacenar la información, incluyendo tablas como:

- estudiantes
- empleados
- pagos
- nomina
- prestaciones
- historial_movimientos

🚀 Funcionalidades Principales

- Interfaz amigable y organizada
- Cálculos automáticos de nómina
- Gestión completa de estudiantes y empleados
- Sistema escalable y adaptable
- Validación de datos

👩‍💻 Créditos

Desarrollado por:

Ana Alcántara
Estudiante de Informática
Desarrolladora principal del sistema SICOLAR

🎓 Contexto Académico

Proyecto desarrollado como parte de un trabajo académico, enfocado en la creación de una solución tecnológica para la gestión administrativa de un centro educativo.

 🛠️ Instalación y Ejecución con Docker

Sigue estos pasos para correr el proyecto localmente usando Docker:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/tu-repo.git
   cd Monografico23_sistemaContble
   ```

2. **Levantar los contenedores:**
   Asegúrate de tener Docker y Docker Compose instalados. Ejecuta el siguiente comando en la raíz del proyecto:
   ```bash
   docker-compose up -d --build
   ```
   *Esto descargará las imágenes de PHP y MySQL, construirá el contenedor del servidor web e inicializará la base de datos automáticamente.*

3. **Acceder a la aplicación:**
   Una vez que los contenedores estén corriendo, abre tu navegador y entra a:
   [http://localhost:8080](http://localhost:8080)

4. **Configuración de la Base de Datos:**
   El sistema está preconfigurado para conectarse automáticamente. Si necesitas acceder manualmente a la base de datos (por ejemplo, vía TablePlus o DBeaver), utiliza los siguientes datos:
   - **Host:** `localhost`
   - **Puerto:** `3306`
   - **Usuario:** `root`
   - **Contraseña:** `0101`
   - **Base de Datos:** `sistemacontable`

5. **Detener el sistema:**
   Para detener los contenedores sin borrar los datos:
   ```bash
   docker-compose stop
   ```
   Para eliminar los contenedores:
   ```bash
   docker-compose down
   ```
