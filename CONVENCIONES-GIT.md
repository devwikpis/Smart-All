# **Convenciones para el Manejo de Git en el Proyecto TDEA**

## **📌 1. Estructura de Ramas (Branching Strategy)**

Se utilizará el flujo  **Git Flow**  adaptado para el proyecto:

-   **`main`**                      → Rama principal con el código estable (producción).
    
-   **`develop`**                   → Rama de integración para features terminados (pre-producción).
    
-   **`feature/[nombre-feature]`**  → Desarrollo de nuevas funcionalidades.
    
-   **`fix/[nombre-fix]`**          → Corrección de bugs.
    
-   **`hotfix/[nombre-hotfix]`**    → Soluciones urgentes en producción.
    

📌  **Ejemplo:**

```bash
git checkout -b feature/nuevo-post-type-cursos
git checkout -b fix/error-formulario-contacto
```
----------

## **📌 2. Convención de Commits**

Los mensajes de commit deben seguir el formato:

[tipo]: [descripción breve] (opcional: #issue)

### **Tipos de commits:**

-   **`feat`**  → Nueva funcionalidad.
    
-   **`fix`**  → Corrección de errores.
    
-   **`refactor`**  → Mejoras de código sin cambiar funcionalidad.
    
-   **`docs`**  → Cambios en documentación.
    
-   **`style`**  → Ajustes de formato (CSS, linting).
    
-   **`chore`**  → Tareas de mantenimiento (dependencias, configs).
    

📌  **Ejemplos:**

```bash
git commit -m "feat: agregar post type 'Cursos' #45"
git commit -m "fix: corregir error en formulario de inscripción"
```
----------

## **📌 3. Política de Pull Requests (PRs)**

-   **Siempre crear PRs desde  `feature/`  o  `fix/`  hacia  `develop`.**
    
-   **Revisión obligatoria**  antes de mergear (mínimo 1 aprobación).
    
-   **Títulos descriptivos**  (ej:  `[FEAT] Nuevo shortcode de calendario académico`).
    
-   **Descripción detallada**  (qué cambia, por qué, cómo probarlo).
    
-   **Referenciar issues**  (ej:  `Closes #12`).
    

----------

## **📌 4. Manejo de Issues**

-   **Etiquetas claras**:
    
    -   `bug`  → Errores.
        
    -   `enhancement`  → Mejoras.
        
    -   `question`  → Dudas o consultas.
        
    -   `urgent`  → Prioridad alta.
        
-   **Asignar responsables**.
    
-   **Usar milestones**  para agrupar tareas por sprints.
    

----------

## **📌 5. Configuración Adicional**

-   **`.gitignore`**  → Excluir archivos innecesarios (node_modules, logs,  `.env`).
    
-   **Commits atómicos**  → Cambios pequeños y enfocados.
    
-   **Sincronizar ramas frecuentemente**  (`git pull origin develop`).
    

----------

## **📌 6. Recomendaciones**

✅  **Antes de hacer push:**

-   Verificar que no hay conflictos (`git status`).
    
-   Ejecutar tests si existen.
    

🚨  **Prohibido:**

-   Hacer push directamente a  `main`  o  `develop`.
    
-   Mergear sin revisión.
    

----------

🔗  **Documentación útil:**

-   [Git Flow](https://nvie.com/posts/a-successful-git-branching-model/)
    
-   [Conventional Commits](https://www.conventionalcommits.org/)
    

----------