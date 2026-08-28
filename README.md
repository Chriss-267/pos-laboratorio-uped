<p align="center">
  <img src="https://res.cloudinary.com/bcwlyire/image/upload/v1785118882/NUEVO-LOGO-UPED-A-COLOR-scaled_szoqws.jpg" alt="Logo Universidad Pedagógica de El Salvador" width="500"/>
</p>

# Laboratorio I: CRUD Diagnóstico en PHP Nativo

**Universidad Pedagógica de El Salvador Dr. Luis Alonso Aparicio**  
**Facultad de Ingeniería**  
**Asignatura:** Integración de Sistemas (`CE-ISC019`) — Ciclo 02-2026  
**Grupo:** Bariloches  

---

## 👥 Integrantes del Equipo

* **Cruz Vásquez, Josthyn Stanley** — `CV-64711-23`
* **Flores Molina, Carlos Ernesto** — `FM-63450-22`
* **Interiano Figueroa, Héctor Alonso** — `IF-64141-23`
* **Monterrosa Portillo, Christian Eduardo** — `MP-64203-23`

---

## 📌 Sistema POS de Facturación

Desarrollo de una solución **POS (Point of Sale)** para la automatización del proceso de facturación y ventas. Este sistema está orientado a modernizar la operativa comercial, garantizar un control preciso del flujo de transacciones y minimizar significativamente el margen de error en la generación de comprobantes y gestión de datos.

### Aspectos Técnicos Clave

- **Programación Orientada a Objetos (POO):** Modelado de clases del dominio aplicando encapsulamiento, abstracción, herencia (`Persona` -> `Cliente`) e implementación de interfaces (`ClienteInterface`).
- **Persistencia Segura con PDO:** Conexión a base de datos relacional mediante la API PDO de PHP, utilizando consultas preparadas (*prepared statements*) para prevenir vulnerabilidades de inyección SQL.
- **Autoloading y Namespaces (PSR-4):** Organización modular del código fuente mapeado mediante Composer, eliminando el uso de `require` o `include` manuales.
- **Patrón MVC (Model-View-Controller):** Separación clara de responsabilidades entre la capa de datos, la lógica de negocio y la interfaz de usuario.
- **Gestión Ágil:** Registro y seguimiento continuo de actividades a través del tablero Kanban durante el ciclo de desarrollo.

---

## 🤖 Uso de Inteligencia Artificial

Para potenciar el desarrollo y documentación del proyecto, se integraron herramientas de IA generativa en áreas específicas:

* **Claude:** Utilizado como asistente de diseño para la maquetación visual, estructura de vistas e implementación de los estilos CSS (`assets/css/estilos.css`).
* **Gemini:** Utilizado para la estructuración, redacción técnica y estandarización del documento `README.md`.

---

## 📋 Tablero Kanban del Proyecto

Puedes consultar el avance, la organización de tareas y el flujo de trabajo del equipo en nuestro tablero de Trello:

📌 [Ver Tablero Kanban en Trello](https://trello.com/invite/b/6a5bba3563bd79af8328e37b/ATTI65d8c56163cb43fc827af7342d804f9b13FAB882/greener-team)

---

## 📁 Estructura del Proyecto

```text
pos-laboratorio-uped/
├── assets/
│   └── css/
│       └── estilos.css           # Estilos visuales del proyecto (Diseñados con Claude)
├── src/
│   └── app/
│       ├── Config/
│       │   └── Database.php      # Conexión a la BD mediante PDO
│       ├── Controllers/
│       │   └── ClienteController.php # Controlador de la entidad Cliente
│       ├── Interfaces/
│       │   └── ClienteInterface.php  # Interfaz para contratos del modelo
│       ├── Models/
│       │   ├── Cliente.php       # Clase Cliente (extiende de Persona)
│       │   └── Persona.php       # Clase base Persona
│       └── Views/
│           └── clientes.index.php # Vista principal para el listado e interfaz
├── .gitignore                    # Exclusión de archivos no rastreados y credenciales
├── composer.json                 # Configuración PSR-4 y dependencias
├── index.php                     # Punto de entrada principal de la aplicación
└── README.md                     # Documentación general del proyecto (Generado con Gemini)