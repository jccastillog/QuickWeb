<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuickWeb - Soluciones Digitales para Emprendedores</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --qw-primary: #2F39BF;
            --qw-secondary: #39DCB1;
            --qw-dark: #0A1E43;
            --qw-light: #F8F9FB;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .qw-bg-gradient {
            background: linear-gradient(135deg, var(--qw-primary) 0%, #061c59 100%);
            color: white;
        }
        
        .qw-btn-primary {
            background-color: var(--qw-secondary);
            color: var(--qw-dark);
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 6px;
            border: none;
            transition: all 0.3s ease;
        }
        
        .qw-btn-primary:hover {
            background-color: #74ffda;
            transform: translateY(-2px);
        }
        
        .qw-section {
            padding: 80px 0;
        }
        
        .qw-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .qw-card:hover {
            transform: translateY(-10px);
        }
        
        .qw-card-icon {
            font-size: 2.5rem;
            color: var(--qw-primary);
            margin-bottom: 1rem;
        }
        
        .qw-feature-list li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
        }
        
        .qw-feature-list li:before {
            content: "✓";
            color: var(--qw-secondary);
            position: absolute;
            left: 0;
            font-weight: bold;
        }
        
        .qw-nav-pills .nav-link {
            color: var(--qw-dark);
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 12px 20px;
            font-weight: 500;
        }
        
        .qw-nav-pills .nav-link.active {
            background-color: var(--qw-primary);
            color: white;
        }
        
        .qw-faq-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        
        .qw-faq-question {
            font-weight: 600;
            color: var(--qw-primary);
        }
        
        @media (max-width: 768px) {
            .qw-section {
                padding: 50px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark qw-bg-gradient sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-globe me-2"></i>QuickWeb
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">Preguntas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">Panel Admin</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn qw-btn-primary" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="qw-bg-gradient qw-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Tu aliado digital para crecer con una web accesible y profesional</h1>
                    <p class="lead mb-4">En QuickWeb creamos sitios web que no solo se ven bien, sino que están diseñados para que cualquier persona, sin importar su nivel técnico, pueda gestionarlos con facilidad.</p>
                    <div class="d-flex gap-3">
                        <a href="#servicios" class="btn qw-btn-primary">Nuestros Servicios</a>
                        <a href="#contacto" class="btn btn-outline-light">Contactar</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Desarrollo web" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Por qué elegirnos -->
    <section class="qw-section bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">¿Por qué elegir QuickWeb?</h2>
                <p class="lead text-muted">Ofrecemos soluciones digitales diseñadas específicamente para emprendedores</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="qw-card p-4 text-center">
                        <div class="qw-card-icon">
                            <i class="fas fa-universal-access"></i>
                        </div>
                        <h4>Diseño Accesible</h4>
                        <p>Sitios intuitivos que cumplen con estándares de accesibilidad para todos tus clientes.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="qw-card p-4 text-center">
                        <div class="qw-card-icon">
                            <i class="fas fa-sliders-h"></i>
                        </div>
                        <h4>Administración Fácil</h4>
                        <p>Panel de control sencillo para que actualices tu contenido sin complicaciones.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="qw-card p-4 text-center">
                        <div class="qw-card-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>Soporte Personalizado</h4>
                        <p>Acompañamiento continuo para que tu negocio crezca en el mundo digital.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="qw-card p-4 text-center">
                        <div class="qw-card-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Hosting Seguro</h4>
                        <p>Nos encargamos del alojamiento y seguridad para que tu sitio esté siempre disponible.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="qw-section bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Nuestros Servicios</h2>
                <p class="lead text-muted">Soluciones completas para tu presencia digital</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="qw-card p-4">
                        <h3 class="text-center mb-4">Básico</h3>
                        <div class="text-center mb-4">
                            <span class="display-4 fw-bold">$499</span>
                            <span class="text-muted">/mes</span>
                        </div>
                        <ul class="qw-feature-list">
                            <li>Diseño web personalizado (1-5 páginas)</li>
                            <li>Panel de administración básico</li>
                            <li>Dominio .com.co (1er año)</li>
                            <li>Hosting compartido</li>
                            <li>Certificado SSL</li>
                            <li>Soporte técnico básico</li>
                        </ul>
                        <div class="text-center mt-4">
                            <a href="#contacto" class="btn qw-btn-primary w-100">Contratar</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="qw-card p-4 position-relative" style="border: 2px solid var(--qw-secondary);">
                        <span class="position-absolute top-0 start-50 translate-middle badge bg-success">Popular</span>
                        <h3 class="text-center mb-4">Estándar</h3>
                        <div class="text-center mb-4">
                            <span class="display-4 fw-bold">$799</span>
                            <span class="text-muted">/mes</span>
                        </div>
                        <ul class="qw-feature-list">
                            <li>Todo en Básico +</li>
                            <li>Hasta 10 páginas</li>
                            <li>Panel de administración avanzado</li>
                            <li>Integración con redes sociales</li>
                            <li>Formulario de contacto</li>
                            <li>Soporte prioritario</li>
                        </ul>
                        <div class="text-center mt-4">
                            <a href="#contacto" class="btn qw-btn-primary w-100">Contratar</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="qw-card p-4">
                        <h3 class="text-center mb-4">Premium</h3>
                        <div class="text-center mb-4">
                            <span class="display-4 fw-bold">$1,199</span>
                            <span class="text-muted">/mes</span>
                        </div>
                        <ul class="qw-feature-list">
                            <li>Todo en Estándar +</li>
                            <li>Sitio ilimitado</li>
                            <li>Tienda online (hasta 50 productos)</li>
                            <li>Pasarela de pagos</li>
                            <li>Blog integrado</li>
                            <li>Soporte 24/7</li>
                        </ul>
                        <div class="text-center mt-4">
                            <a href="#contacto" class="btn qw-btn-primary w-100">Contratar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sobre Nosotros -->
    <section id="nosotros" class="qw-section bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Equipo QuickWeb" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Sobre Nosotros</h2>
                    <p>QuickWeb nace con una misión clara: Hacer que el mundo digital sea accesible para todos los emprendedores.</p>
                    <p>Sabemos que iniciar un negocio es un reto y que muchas veces el entorno tecnológico parece complicado o costoso. Por eso, creamos una solución pensada especialmente para ti: sitios web profesionales, fáciles de administrar y al alcance de cualquier emprendimiento.</p>
                    
                    <h4 class="mt-5 mb-3">Nuestra Filosofía</h4>
                    <ul class="qw-feature-list">
                        <li>La simplicidad como camino hacia lo funcional</li>
                        <li>La accesibilidad como derecho, no como lujo</li>
                        <li>El acompañamiento como clave para el crecimiento</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Preguntas Frecuentes -->
    <section id="faq" class="qw-section bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Preguntas Frecuentes</h2>
                <p class="lead text-muted">Resolvemos tus dudas más comunes</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="qw-faq-item">
                        <h4 class="qw-faq-question">1. ¿Qué incluye el servicio de creación de mi página web?</h4>
                        <p>Incluye el diseño personalizado de tu sitio, una página de administración para que puedas editar tu contenido fácilmente, alojamiento web (hosting), dominio .com.co, certificado de seguridad SSL y asesoría básica en contenidos.</p>
                    </div>
                    
                    <div class="qw-faq-item">
                        <h4 class="qw-faq-question">2. ¿Tengo que saber de programación para administrar mi web?</h4>
                        <p>No. Te entregamos una interfaz sencilla e intuitiva para que tú mismo puedas actualizar textos, imágenes y productos sin necesidad de conocimientos técnicos.</p>
                    </div>
                    
                    <div class="qw-faq-item">
                        <h4 class="qw-faq-question">3. ¿Cuánto tiempo tarda en estar lista mi página?</h4>
                        <p>El tiempo promedio de entrega es de 7 a 10 días hábiles, dependiendo de la rapidez con la que recibamos el contenido (textos, fotos, etc.) y las revisiones necesarias.</p>
                    </div>
                    
                    <div class="qw-faq-item">
                        <h4 class="qw-faq-question">4. ¿Puedo tener una tienda online con carrito de compras?</h4>
                        <p>Sí. Ofrecemos planes que incluyen funcionalidades de comercio electrónico, pasarelas de pago y gestión de productos.</p>
                    </div>
                    
                    <div class="qw-faq-item">
                        <h4 class="qw-faq-question">5. ¿El servicio incluye dominio y hosting?</h4>
                        <p>Sí. Todos nuestros planes incluyen dominio .com.co, alojamiento web (hosting) y certificado SSL, durante el primer año. Luego podrás renovarlos con nosotros a precios accesibles.</p>
                    </div>
                    
                    <div class="text-center mt-5">
                        <a href="#contacto" class="btn qw-btn-primary">¿Tienes más preguntas? Contáctanos</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="qw-section qw-bg-gradient text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-4">¿Listo para comenzar tu proyecto digital?</h2>
                    <p class="lead mb-5">Contáctanos hoy y da el primer paso para hacer crecer tu negocio con una web accesible, profesional y hecha a tu medida.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-4 bg-white text-dark rounded-3 h-100">
                                <i class="fas fa-phone qw-card-icon"></i>
                                <h4>Teléfono</h4>
                                <p>+57 123 456 7890</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="p-4 bg-white text-dark rounded-3 h-100">
                                <i class="fas fa-envelope qw-card-icon"></i>
                                <h4>Email</h4>
                                <p>info@quickweb.com</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="p-4 bg-white text-dark rounded-3 h-100">
                                <i class="fas fa-map-marker-alt qw-card-icon"></i>
                                <h4>Ubicación</h4>
                                <p>Bogotá, Colombia</p>
                            </div>
                        </div>
                    </div>
                    
                    <form class="mt-5 bg-white p-4 rounded-3 text-dark">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Nombre completo" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Correo electrónico" required>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Asunto">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" rows="4" placeholder="Mensaje" required></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn qw-btn-primary">Enviar Mensaje</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2023 QuickWeb. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para el login (preparado para implementación) -->
    <script>
        // Aquí puedes agregar la lógica para el sistema de login cuando lo implementes
        document.addEventListener('DOMContentLoaded', function() {
            // Ejemplo: Scroll suave para los enlaces
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>