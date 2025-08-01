<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Словник-довідник - Автор</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&family=Roboto+Condensed:wght@300;400;500;600;700&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto Slab', serif;
            background-color: #FFFFFF;
        }

        .dictionary-container {
            width: 1440px;
            height: 1326px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            background-color: #FFFFFF;
        }

        /* Header */
        .dictionary-header {
            width: 1440px;
            height: 353px;
            padding: 20px 120px 0px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 14px;
            border-bottom: 1px solid #FEC200;
        }

        .dictionary-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .dictionary-logo {
            display: flex;
            align-items: center;
            gap: 20px;
            width: 349px;
            height: 59px;
        }

        .dictionary-logo-icon {
            width: 36px;
            height: 36px;
            position: relative;
        }

        .dictionary-logo-text {
            font-family: 'Roboto Slab', serif;
            font-weight: 900;
            font-size: 32px;
            line-height: 1.32;
            color: #000000;
        }

        .dictionary-navigation {
            display: flex;
            align-items: center;
            gap: 34px;
        }

        .dictionary-nav-item {
            font-family: 'Roboto Condensed', sans-serif;
            font-weight: 500;
            font-size: 14px;
            line-height: 1.17;
            text-transform: uppercase;
            color: #3F3F3F;
            text-decoration: none;
        }

        .dictionary-header-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 261px;
            width: 100%;
        }

        .dictionary-header-title {
            font-family: 'Roboto Slab', serif;
            font-weight: 900;
            font-size: 48px;
            line-height: 1.32;
            text-transform: uppercase;
            color: #28569A;
        }

        .dictionary-header-image {
            width: 362px;
            height: 253px;
            background-color: #ccc;
            border-radius: 10px;
        }

        /* Main Content */
        .dictionary-main-content {
            display: flex;
            gap: 26px;
            margin: 422px 120px 0;
            width: 1200px;
            height: 545px;
        }

        .dictionary-content-left {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 20px;
            width: 386px;
            border: 1px solid #5B80DF;
            border-radius: 10px;
        }

        .dictionary-content-image {
            width: 100%;
            height: 260.47px;
            background-color: #f0f0f0;
            border-radius: 8px;
        }

        .dictionary-content-right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 40px;
            width: 756px;
        }

        .dictionary-content-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
        }

        .dictionary-content-text {
            font-family: 'Roboto Slab', serif;
            font-weight: 400;
            font-size: 20px;
            line-height: 1.32;
            color: #575757;
        }

        .dictionary-reference-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 28px 20px;
            border: 1px solid #FFBB00;
            border-radius: 10px;
            width: 100%;
        }

        .dictionary-reference-text {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 20px;
            line-height: 1.17;
            color: #575757;
            width: 716px;
        }

        .dictionary-reference-box-small {
            display: flex;
            gap: 10px;
            padding: 20px;
            border: 1px solid #FFBB00;
            border-radius: 10px;
            width: 100%;
        }

        .dictionary-reference-text-small {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 20px;
            line-height: 1.17;
            color: #575757;
            width: 652px;
        }

        /* Background Elements */
        .dictionary-bg-shape {
            position: absolute;
            left: -187px;
            top: 166px;
            width: 287.23px;
            height: 311.42px;
            background-color: #f0f0f0;
            border-radius: 50%;
        }

        /* Footer */
        .dictionary-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 1440px;
            height: 398px;
            background-color: #94BDDD;
            padding: 62px 120px;
        }

        .dictionary-footer-content {
            display: flex;
            gap: 22px;
        }

        .dictionary-footer-section {
            display: flex;
            flex-direction: column;
            gap: 63px;
            width: 282px;
        }

        .dictionary-footer-title {
            font-family: 'Roboto Slab', serif;
            font-weight: 700;
            font-size: 24px;
            line-height: 1.32;
            text-transform: uppercase;
            color: #205692;
        }

        .dictionary-footer-links {
            display: flex;
            flex-direction: column;
            gap: 21px;
        }

        .dictionary-footer-link {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 24px;
            line-height: 1.21;
            color: #FFFFFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="dictionary-container">
        <!-- Header -->
        <header class="dictionary-header">
            <div class="dictionary-top-bar">
                <div class="dictionary-logo">
                    <div class="dictionary-logo-icon">
                        <!-- SVG иконка книг -->
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                            <path d="M2.95 21.4h11.26v11.83H2.95z" fill="#D32A2A"/>
                            <path d="M0.19 12.2h7.79v9.2H0.19z" fill="#132028"/>
                            <path d="M5.93 1.89h9.52v10.32H5.93z" fill="#005877"/>
                            <path d="M15.44 1.89h19.1v10.32H15.44z" fill="#00B1FF"/>
                            <path d="M4.08 12.2h29.61v9.2H4.08z" fill="#445056"/>
                            <path d="M5.76 13.81h26.25v5.85H5.76z" fill="#DCE2E2"/>
                            <path d="M10.28 1.89h7.74v10.32H10.28z" fill="#0074A8"/>
                            <path d="M12.18 3.54h21.56v7.01H12.18z" fill="#DCE2E2"/>
                            <path d="M6.99 21.4h28.67v11.83H6.99z" fill="#FF473E"/>
                            <path d="M9.16 23.3h25.58v8.04H9.16z" fill="#DCE2E2"/>
                        </svg>
                    </div>
                    <div class="dictionary-logo-text">schoolbook</div>
                </div>
                <nav class="dictionary-navigation">
                    <a href="#" class="dictionary-nav-item">зміст</a>
                    <a href="#" class="dictionary-nav-item">словник-довідник</a>
                    <a href="#" class="dictionary-nav-item">персоналії</a>
                    <a href="#" class="dictionary-nav-item">медіа контент</a>
                    <a href="#" class="dictionary-nav-item">рекомендована література</a>
                </nav>
            </div>
            <div class="dictionary-header-content">
                <div class="dictionary-header-title">Автор</div>
                <div class="dictionary-header-image"></div>
            </div>
        </header>

        <!-- Background Shape -->
        <div class="dictionary-bg-shape"></div>

        <!-- Main Content -->
        <main class="dictionary-main-content">
            <div class="dictionary-content-left">
                <div class="dictionary-content-image"></div>
            </div>
            <div class="dictionary-content-right">
                <div class="dictionary-content-section">
                    <p class="dictionary-content-text">Автор – це фізична особа, творчою працею якої створено твір.</p>
                    <div class="dictionary-reference-box">
                        <p class="dictionary-reference-text">Літературознавчий словник-довідник, 2-е вид., випр. і доп. / Р.Т. Громʼяк, Ю.І. Ковалів та ін. Київ : ВЦ "Академія", 2006. 752 с.</p>
                    </div>
                </div>
                <div class="dictionary-content-section">
                    <p class="dictionary-content-text">Автор – той, хто створив твір; іноді автор присутній у творі як ліричний герой, іноді ніби грає роль автора, спілкується із читачем, часом створює образ наближеного до себе персонажа, свого другого "Я". Але навіть коли автор не з'являється у творі, нічим не видає себе, ми відчуваємо його присутність – за мовою, за тим ставленням до героїв чи подій, яке виникає в читачів із волі автора.</p>
                    <div class="dictionary-reference-box-small">
                        <p class="dictionary-reference-text-small">Моклиця М. Вступ до літературознавства : посібник для студентів філологічних факультетів. Луцьк, 2011. 467 с.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="dictionary-footer">
            <div class="dictionary-footer-content">
                <div class="dictionary-footer-section">
                    <h3 class="dictionary-footer-title">зміст</h3>
                    <div class="dictionary-footer-links">
                        <a href="#" class="dictionary-footer-link">Передмова</a>
                        <a href="#" class="dictionary-footer-link">Розділ 1</a>
                        <a href="#" class="dictionary-footer-link">Розділ 2</a>
                        <a href="#" class="dictionary-footer-link">Розділ 3</a>
                    </div>
                </div>
                <div class="dictionary-footer-section">
                    <h3 class="dictionary-footer-title">Контент</h3>
                    <div class="dictionary-footer-links">
                        <a href="#" class="dictionary-footer-link">Словник-довідник</a>
                        <a href="#" class="dictionary-footer-link">Персоналії</a>
                        <a href="#" class="dictionary-footer-link">Тестування</a>
                    </div>
                </div>
                <div class="dictionary-footer-section">
                    <h3 class="dictionary-footer-title">Посилання</h3>
                    <div class="dictionary-footer-links">
                        <a href="#" class="dictionary-footer-link">Медіа-контент</a>
                        <a href="#" class="dictionary-footer-link">Бібліотека</a>
                        <a href="#" class="dictionary-footer-link">Художні тексти</a>
                    </div>
                </div>
                <div class="dictionary-footer-section">
                    <h3 class="dictionary-footer-title">зміст</h3>
                    <div class="dictionary-footer-links">
                        <a href="#" class="dictionary-footer-link">Розділ 1</a>
                        <a href="#" class="dictionary-footer-link">Розділ 2</a>
                        <a href="#" class="dictionary-footer-link">Розділ 3</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html> 