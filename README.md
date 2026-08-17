<p align="center">
  <img src="https://res.cloudinary.com/bcwlyire/image/upload/v1785118882/NUEVO-LOGO-UPED-A-COLOR-scaled_szoqws.jpg" alt="Logo Universidad Pedagógica de El Salvador" width="500"/>
</p>

# Laboratorio I: CRUD Diagnóstico en PHP Nativo

**Universidad Pedagógica de El Salvador Dr. Luis Alonso Aparicio**  
**Facultad de Ingeniería**  
**Asignatura:** Integración de Sistemas (`CE-ISC019`) — Ciclo 02-2026  

---

## 📌 Descripción del Proyecto

Este proyecto consiste en un sistema **CRUD (Create, Read, Update, Delete)** funcional desarrollado en **PHP nativo**, aplicado al dominio de gestión de **Clientes**. Fue diseñado para evaluar e integrar fundamentos clave de arquitectura de software, persistencia segura de datos y buenas prácticas de desarrollo en PHP.

### Key Technical Aspects

- **Programación Orientada a Objetos (POO):** Modelado de clases del dominio aplicando encapsulamiento, abstracción, una relación de herencia y la implementación de al menos una interfaz.
- **Persistencia Segura con PDO:** Conexión a base de datos relacional mediante la API PDO de PHP, utilizando consultas preparadas (*prepared statements*) para evitar vulnerabilidades de inyección SQL.
- **Autoloading y Namespaces (PSR-4):** Organización modular del código fuente mapeado mediante Composer, eliminando el uso de `require` o `include` relativos manuales.
- **Patrón MVC (Model-View-Controller):** Separación de responsabilidades entre el modelo del dominio (`Cliente`), el controlador (`ClienteController`) y las vistas de interfaz de usuario.
- **Gestión Ágil:** Registro y seguimiento continuo de actividades a través del tablero Kanban durante el ciclo de desarrollo.

---

## 📋 Tablero Kanban del Proyecto

Puedes consultar el avance, la organización de tareas y el flujo de trabajo del equipo en nuestro tablero de Trello:

📌 [Ver Tablero Kanban en Trello](https://trello.com/invite/b/6a5bba3563bd79af8328e37b/ATTI65d8c56163cb43fc827af7342d804f9b13FAB882/greener-team)

---

## 📁 Estructura del Proyecto

```text
lab1-pos-laboratorio-uped-[Greener]/
├── src/
│   └── app/
│       ├── Config/
│       │   └── Database.php          # Conexión a la BD mediante PDO
│       ├── Controllers/
│       │   └── ClienteController.php # Controlador de la entidad Cliente
│       ├── Models/
│       │   └── Cliente.php           # Modelo del dominio Cliente
│       └── Views/
│           └── clientes.index.php    # Vista principal para el listado e interfaz
├── vendor/                           # Dependencias y Autoload de Composer (ignorado en git)
├── .gitignore                        # Exclusión de /vendor y credenciales sensibles
├── composer.json                     # Configuración PSR-4 y dependencias
├── index.php                         # Punto de entrada de la aplicación
└── README.md                         # Documentación del proyecto
