# Tema WordPress - Tecnológico de Antioquia (TdeA)

## Descripción 📄
Tema oficial para el sitio web institucional del Tecnológico de Antioquia, desarrollado con estándares de accesibilidad y rendimiento.

## 🚀 Requisitos Técnicos

### Dependencias
- Node.js v18+
- Gestor de paquetes:
  - **Recomendado:** pnpm (`npm install -g pnpm`)
  - **Alternativas:** bun, npm o yarn

### 📂 Directorio Principal
```bash
TdeA/  
├── admin/ # Funcionalidades del área administrativa  
│ └── class-tdea-admin.php # Clase principal de administración  
├── css/ # Hojas de estilo CSS (generadas)  
├── js/ # JavaScript compilado  
├── inc/ # Componentes del núcleo del tema  
│ ├── class-tdea-ajax-handler.php # Manejo de peticiones AJAX  
│ ├── class-tdea-master.php # Clase principal  
│ └── class-tdea-hooks-manager.php # Gestión de hooks  
├── includes/ # Funcionalidades adicionales  
│ ├── class-tdea-renderer.php # Renderizado de componentes  
│ └── class-tdea-shortcodes.php # Shortcodes personalizados  
├── public/ # Funcionalidades frontend  
│ └── class-tdeapublic.php # Clase principal del frontend  
├── src/ # Código fuente (SCSS/JS)  
├── template-parts/ # Componentes reutilizables  
├── templates/ # Plantillas personalizadas
```

## 📄 Archivos Principales
```bash
├── .gitignore # Archivos excluidos de Git  
├── 404.php # Plantilla de error 404  
├── footer.php # Pie de página  
├── front-page.php # Página de inicio  
├── functions.php # Configuración principal  
├── header.php # Cabecera del sitio  
├── index.php # Plantilla por defecto  
├── package.json # Dependencias y scripts  
├── README.md # Documentación  
├── screenshot.png # Vista previa del tema  
├── style.css # Informacion del tema para wordpress
└── webpack.mix.js # Configuración de Mix
```

## 🛠️ Comandos básicos

```bash
# Instalar dependencias
pnpm install

# Modo desarrollo
pnpm dev

# Compilar para producción
pnpm build
```
## 🧱 Metodología BEM
### Estructura básica
```css
.bloque {
  &__elemento {
    &--modificador { ... }
  }
}
```
### Ejemplo práctico
```html
<nav class="nav">
  <a href="/" class="nav__link nav__link--active">Inicio</a>
</nav>
```
> Documentación oficial: [BEM Methodology](https://en.bem.info/methodology/)
## ♿ Accesibilidad Web

### Requisitos esenciales

-   ✔️ Contraste 4.5:1 mínimo
    
-   ✔️ Navegación por teclado
    
-   ✔️ Semántica HTML5
    
-   ✔️ TDEAibutos ARIA

```html
<img src="logo.jpg" alt="TdeA - Educación superior" width="200">
```
## 📚 Recursos oficiales

-   [WCAG 2.1](https://www.w3.org/TR/WCAG21/)
    
-   [WebAIM](https://webaim.org/)
    
-   [ARIA Practices](https://www.w3.org/WAI/ARIA/apg/)
    

## 📝 Licencia

GNU GPL v3.0 ©  [Tecnológico de Antioquia](https://tdea.edu.co/)