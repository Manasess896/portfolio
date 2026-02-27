<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Privacy Policy for Intelligent WhatsApp Bot. Learn how we collect, use, and protect your data including conversation history and location information.">
    <meta name="keywords" content="Privacy Policy, Data Protection, WhatsApp Bot, AI Privacy, User Data, GDPR, Chatbot Security">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://manases.space/ai/privacy-policy">
    <meta property="og:title" content="Privacy Policy - Intelligent ChatBot">
    <meta property="og:description" content="How we handle your data, conversation history, and privacy rights for the Intelligent WhatsApp Bot.">
    <meta property="og:image" content="https://manases.space/images/company_logo.png">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://manases.space/ai/privacy-policy">
    <meta property="twitter:title" content="Privacy Policy - Intelligent ChatBot">
    <meta property="twitter:description" content="How we handle your data, conversation history, and privacy rights for the Intelligent WhatsApp Bot.">
    <meta property="twitter:image" content="https://manases.space/images/company_logo.png">

    <title>Privacy Policy - Intelligent ChatBot</title>
    <link rel="icon" href="../images/company_logo.png" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .main-document {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: system-ui, -apple-system, sans-serif;
        }

        h1,
        h2,
        h3 {
            font-weight: 600;
            color: #111;
            margin-top: 1.5rem;
        }

        p,
        li {
            line-height: 1.6;
            color: #444;
        }

        a {
            color: #000;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-document">
            <h1 class="text-center mb-4">Privacy Policy</h1>
            <p class="text-center text-muted mb-5">Last Updated: February 22, 2026</p>

            <section>
                <h2>1. Introduction</h2>
                <p>This Privacy Policy applies to the Intelligent WhatsApp Bot ("the Service"). We respect your privacy and are committed to protecting the personal information you share with us. This policy outlines how we collect, use, maintain, and disclose information collected from users.</p>
            </section>

            <section>
                <h2>2. Information We Collect</h2>
                <p>We collect information necessary to provide the chat functionality and improve user experience:</p>
                <ul>
                    <li><strong>Personal Identity Information:</strong> We collect your WhatsApp phone number and your public WhatsApp profile name. This is used solely to identify your session and maintain conversation history.</li>
                    <li><strong>Conversation Content:</strong> We store the text messages you send and the bot's responses. This is essential for the AI to "remember" the context of your conversation (Context-Aware Conversations).</li>
                    <li><strong>Location Data:</strong> We automatically detect your country based on the country code of your phone number. This is used to provide culturally relevant responses and localized content. We do not track your real-time GPS location.</li>
                    <li><strong>Metadata and Logs:</strong> We collect technical logs regarding message delivery, error timestamps, and system performance to debug issues and ensure reliability.</li>
                </ul>
            </section>

            <section>
                <h2>3. How We Use Your Information</h2>
                <p>The information we collect is used for the following specific purposes:</p>
                <ul>
                    <li><strong>Service Functionality:</strong> To process your messages via the AI models and deliver responses back to you on WhatsApp.</li>
                    <li><strong>Personalization:</strong> To tailor responses based on your detected location (e.g., using relevant currency, units of measurement, or cultural references).</li>
                    <li><strong>Persistent Memory:</strong> To allow the bot to recall previous parts of the conversation, creating a continuous and natural dialogue flow.</li>
                    <li><strong>Service Improvement:</strong> To analyze usage patterns and fix technical errors.</li>
                </ul>
            </section>

            <section>
                <h2>4. Data Storage and Retention</h2>
                <p>Your data is stored securely using <strong>MongoDB Atlas</strong>. We implement reasonable security practices to protect your data.</p>
                <ul>
                    <li><strong>Retention Period:</strong> Conversation history is retained to provide persistent memory. You may request deletion of your data at any time.</li>
                    <li><strong>Security:</strong> We use strict access controls and environment variable management to protect database credentials. However, no method of transmission over the Internet is 100% secure.</li>
                </ul>
            </section>

            <section>
                <h2>5. Third-Party Data Sharing</h2>
                <p>To operate the Service, we must share specific data with trusted third-party infrastructure providers. We do not sell, trade, or rent your personal identification information to others.</p>
                <ul>
                    <li><strong>Groq API (AI Inference):</strong> Your message content is sent to Groq Inc. to be processed by LLaMA AI models. This is necessary to generate the intelligent responses.</li>
                    <li><strong>Meta (WhatsApp):</strong> As this is a WhatsApp-based service, all messages pass through Meta's WhatsApp Cloud API infrastructure.</li>
                    <li><strong>MongoDB Atlas:</strong> Your user profile and conversation logs are hosted on MongoDB Atlas cloud servers.</li>
                </ul>
                <p>These third parties have their own privacy policies governing how they handle data processed on their systems.</p>
            </section>

            <section>
                <h2>6. Your Rights (GDPR & User Control)</h2>
                <p>You have control over your data. You have the right to:</p>
                <ul>
                    <li><strong>Access:</strong> Request a copy of the personal data we hold about you.</li>
                    <li><strong>Rectification:</strong> Request correction of inaccurate data.</li>
                    <li><strong>Erasure (Right to be Forgotten):</strong> Request the deletion of your user profile and conversation history from our database.</li>
                    <li><strong>Restriction:</strong> Request restriction of processing of your personal data.</li>
                </ul>
                <p>To exercise these rights, please contact the developer via the methods listed in the Contact section.</p>
            </section>

            <section>
                <h2>7. Children's Privacy</h2>
                <p>The Service is not intended for use by children under the age of 13. We do not knowingly collect personal information from children under 13. If we discover that a child under 13 has provided us with personal information, we will delete such information from our servers immediately.</p>
            </section>

            <section>
                <h2>8. Changes to This Privacy Policy</h2>
                <p>We update this privacy policy from time to time. When we do, we will revise the updated date at the top of this page. We encourage users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect.</p>
            </section>

            <section>
                <h2>9. Contact Us</h2>
                <p>If you have any questions about this Privacy Policy, please contact the developer via:</p>
                 <ul>
                    <li><a href="https://manases.space/contact-us" target="_blank">Developer Contact Form</a></li>
                    <li><a href="https://github.com/Manasess896/Advanced-Whatsapp-Bot" target="_blank">GitHub Repository</a></li>
                    <li><a href="https://wa.me/254114471302" target="_blank">Contact on WhatsApp</a></li>
                     <li>View our <a href="terms-of-service">Terms of Service</a></li>
                </ul>
            </section>
        </div>
    </div>
</body>

</html>