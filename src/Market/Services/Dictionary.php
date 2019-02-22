<?php
namespace Market\Services;

/**
 * App dictionary
 */
trait Dictionary
{
    public function getDictionary($lang)
    {
        $title = 'E-Com Plus Addons';
        $subtitle = 'Subtitulo';
        $description_mkp = 'Marketplace de apps e temas para e-commerce';
        switch ($lang) {
            case 'en_us':
                $title = 'E-Com Plus Addons';
                $subtitle = 'Ecommerce apps and themes marketplace';
                $description_mkp = 'is the best e-commerce theme and app marketplace designed to enable retailers who do not have large investment capacity to access a customized quality layout at the best price.';
                $welcome = 'Welcome to ';
                $welcome_only = 'Welcome';
                $word_details = 'Details';
                $word_partner = 'Partners ';
                $word_shopkeeper = 'Shopkeeper ';
                $word_app = 'Apps ';
                $word_theme = 'Themes ';
                $word_plans = 'Plans';
                $word_plan = 'Plan';
                $word_add = 'Add';
                $word_remove = 'Remove';
                $word_value = 'Value';
                $word_and = 'and ';
                $word_yes = 'Yes';
                $word_no = 'No';
                $word_close = 'Close';
                $word_documentation = 'Documentation';
                $word_authentication = 'Authentication';
                $word_register = 'Register ';
                $word_search = 'Search ';
                $word_go_item = 'Go to item';
                $word_favorate_add = 'Favorites +';
                $desc_promo_partners = 'Advertise your APP or theme here with ';
                $desc_promo_store = 'Find the best apps and theme for your ecommerce ';
                $word_start = 'Start ';
                $word_now = 'Now ';
                $buy_now = 'Buy Now ';
                $word_buying = 'Buying ';
                $word_in = 'In';
                $word_by = 'By';
                $apps_trends = 'Apps Trends ';
                $themes_trends = 'Themes Trends ';
                $word_reputation = "Author's Reputation";
                $word_language = 'Select Language';
                $word_select_category = 'Select Category';
                $word_name_of_item = 'Name of the Item';
                $word_max_char = 'Max 40 Characters';
                $word_num_version = 'Num Version';
                $word_date_version = 'Date Version';
                $word_description_scopes = 'Use the switches below to indicate which features your application will consume from the user.';
                $word_search_apps_themes = 'Search For apps or themes ...';
                $word_buy_apps = 'Buy & Sell easily Apps Easily';
                $description_buy_apps = 'Marketplace for shopkeepers and developers for e-commerce ';
                $word_secure_transation = 'Secure Transaction';
                $description_secure_transation = 'The intermediation of the shopkeeper with the developers is done by the ' . $title;
                $word_community = 'Community ';
                $description_community = 'Check the evaluation of other shopkeepers about the products purchased ';
                $word_mkp_quality = 'Customize ';
                $description_mkp_quality = 'Practically and affordably, leave your store with your face! ';
                $word_how_works = 'How it works';
                $word_apps_store = 'Apps Stores';
                $word_items_found = 'Items found';
                $word_not_found = 'not found';
                $word_price = 'Price';
                $word_paid = 'Paid';
                $word_free_trial = 'Free Trial';
                $word_frequency = 'Frequency';
                $word_frequency = 'Frequency';
                $word_themes_store = 'Themes Store';
                $word_profile_page = 'Profile page ';
                $word_account_settings = 'Change Password';
                $word_change_picture = 'New Picture';
                $word_sales_statment = 'Sales Statment ';
                $word_withdrawals = 'Withdrawls ';
                $word_manage_items = 'Manage items';
                $word_upload_item = 'Upload item';
                $word_submit_item = 'Submit item';
                $word_specifications = 'Item Specifications';
                $word_login_account = 'Login to your Account';
                $description_login = 'Log in now to your account and start releasing your APP and Themes!';
                $word_password = 'Password';
                $word_forgot_pssw = 'Forgot your password?';
                $word_remember_user = 'Remember username and password';
                $word_click_here = 'Click here!';
                $word_transaction_history = 'Transaction History';
                $word_favorate = 'Favorites';
                $word_enter_username = 'Enter your Login here...';
                $word_enter_pass = 'Enter your Password here...';
                $word_invalid_login = 'Login or password invalid';
                $word_sucess_login = 'Login done successfully';
                $word_email_invalid = 'E-mail invalid';
                $word_passwd_invalid = 'Password invalid';
                $word_profile_author = "Author's Profile";
                $word_member_since = 'Member Since:';
                $word_total_sales = 'Total Sales:';
                $word_author_itens = "Author's Items";
                $word_author_badges = 'Author Badges';
                $word_recommended = 'Recommended';
                $word_see_all_items = 'See all the items ';
                $word_lastes_items = 'Latest Items';
                $word_see_all_message = 'See all the Messages';
                $word_lastes_message = 'Latest Messages';
                $word_buyer = 'PURCHASED';
                $word_read_all_reviews = 'Read all the Customer Reviews ';
                $word_comments = 'Reviews';
                $word_your_account = 'Your Account';
                $word_info_account = 'Account information';
                $word_tool_acoount = 'Account Tools';
                $word_your_dashboard = 'Your Dashboard';
                $word_profile_info = 'Profile Infomation';
                $word_profile_image = 'Profile Photo';
                $word_country = 'Country';
                $word_name = 'Name';
                $word_account_name = 'Account Name';
                $word_enter_name = 'Enter your name';
                $word_new_password = 'New Password';
                $word_repeat_password = 'Repeat Password';
                $word_select_country = 'Select your Country...';
                $word_enter_repeat_pss = 'Repeat your password here ...';
                $word_enter_email = 'Enter your email address here...';
                $word_enter_website = 'Enter your website link here...';
                $word_about_you = 'About you';
                $word_describe_you = 'Describe about you (max 140 characters)';
                $word_upload_image = 'Upload Image...';
                $word_minimun_size = 'Minimum size';
                $word_save = 'Save';
                $word_dashboard = 'Dashboard';
                $word_items_sold = 'Items Sold';
                $word_total_earnings = 'Total earnings';
                $word_from_sales = 'from sales';
                $word_up_to_now = 'up to now';
                $word_all_categories = 'All Categories ';
                $word_product_sourcing = 'Product Sourcing';
                $word_marketing = 'Marketing';
                $word_sales = 'Sales';
                $word_social_media = 'Social Media';
                $word_shipping = 'Shipping';
                $word_inventory = 'Inventory';
                $word_customer_service = 'Customer Service';
                $word_tools = 'Tools';
                $word_reporting = 'Reporting';
                $word_sales_channels = 'Sales Channels';
                $word_art_photography = 'Art & Photography';
                $word_clothing_fashion = 'Clothing & Fashion';
                $word_jewelry_accessories = 'Jewelry & Accessories';
                $word_electronics = 'Electronics';
                $word_food_drinks = 'Food & Drinks';
                $word_home_garden = 'Home & Garden';
                $word_furniture = 'Furniture ';
                $word_health_beauty = 'Health & Beauty ';
                $word_sports_recreation = 'Sports & Recreation';
                $word_toys_games = 'Toys & Games';
                $word_service = 'Service';
                $word_other = 'Other';
                $word_categories = 'Categories';
                $word_search_empty = 'The search is empty.';
                $word_title_description = 'Title Description';
                $word_title_short_description = 'Short Description';
                $word_placeholde_description = 'you can use markdown syntax';
                $word_version = 'Version';
                $word_version_date = 'Version date';
                $word_type_of_app = 'Type';
                $word_create_account = 'Create Your Account';
                $word_account_partner = 'Create Account Partner';
                $word_create_password = 'Create password';
                $word_info_create_password = 'is the page for creating your password to register your items in our Marketplace.';
                $word_verify = 'Verify';
                $word_installations = 'installations';
                $word_install = 'Install';
                $word_cancel = 'Cancel';
                $word_galery = 'Galery';
                $word_support = 'Support';
                $word_installation_title = 'The application request the following authorizations';
                $word_evaluation = 'Evaluation';
                break;

            default:
                $title = 'E-Com Plus Addons';
                $subtitle = 'Marketplace de apps e temas para e-commerce';
                $description_mkp = 'é o melhor marketplace de apps e temas para e-commerce, criado para possibilitar que lojistas que não tem grande capacidade de investimento tenham acesso a um layout personalizado de qualidade pelo melhor preço.';
                $welcome = 'Bem vindo a ';
                $welcome_only = 'Bem vindo';
                $word_details = 'Detalhes';
                $word_partner = 'Parceiros ';
                $word_shopkeeper = 'Lojistas ';
                $word_app = 'Apps ';
                $word_theme = 'Temas ';
                $word_plans = 'Planos';
                $word_plan = 'Plano';
                $word_value = 'Valor';
                $word_add = 'Adicionar';
                $word_remove = 'Remover';
                $word_and = 'e ';
                $word_yes = 'Sim';
                $word_no = 'Não';
                $word_close = 'Fechar';
                $word_documentation = 'Documentação';
                $word_authentication = 'Autenticação';
                $word_register = 'Registar-se ';
                $word_search = 'Buscar ';
                $word_go_item = 'Ir até item';
                $word_favorate_add = 'Add Favoritos';
                $desc_promo_partners = 'Divulgue sua APP ou tema aqui com ';
                $desc_promo_store = 'Encontre os melhores apps e tema para sua ecommerce ';
                $word_start = 'Começar ';
                $word_now = 'Agora ';
                $buy_now = 'Comprar Agora ';
                $word_buying = 'Comprar ';
                $word_in = 'Em';
                $word_by = 'Por';
                $apps_trends = 'Apps em Destaques';
                $themes_trends = 'Temas em Destaques';
                $word_reputation = 'Reputação do Autor';
                $word_language = 'Selecionar Idioma';
                $word_select_category = 'Escolha uma categoria';
                $word_name_of_item = 'Título do item';
                $word_max_char = 'Max 40 caracteres';
                $word_num_version = 'Número da Versão';
                $word_date_version = 'Data da Versão';
                $word_description_scopes = 'Use os switches abaixo para indicar quais recursos seu aplicativo irá consumir do usuário.';
                $word_search_apps_themes = 'Buscar por Apps ou Temas ...';
                $word_buy_apps = 'Compre & Venda facilmente';
                $description_buy_apps = 'Marketplace para lojistas e desenvolvedores para e-commerce ';
                $word_secure_transation = 'Transação Segura';
                $description_secure_transation = 'A intermediação do lojista com os desenvolvedores é feita pela ' . $title;
                $word_community = 'Comunidade';
                $description_community = 'Confira a avaliação de outros lojistas sobre os apps ou temas comprados. ';
                $word_mkp_quality = 'Personalize ';
                $description_mkp_quality = 'De forma prática e com um preço acessível, deixe sua loja com sua cara! ';
                $word_how_works = 'Como funciona ';
                $word_apps_store = 'Loja de Apps';
                $word_items_found = 'Items encontrados';
                $word_not_found = 'não encontrado';
                $word_price = 'Preço';
                $word_paid = 'Pago';
                $word_free_trial = 'Período de teste';
                $word_frequency = 'Frequência';
                $word_themes_store = 'Loja de Temas';
                $word_profile_page = 'Perfil ';
                $word_account_settings = 'Alterar Senha';
                $word_change_picture = 'Enviar nova Foto';
                $word_sales_statment = 'Histórico de vendas';
                $word_withdrawals = 'Saques ';
                $word_manage_items = 'Gerenciar itens';
                $word_upload_item = 'Envio de item ';
                $word_submit_item = 'Enviar item';
                $word_specifications = 'Especificações';
                $word_login_account = 'Faça login na sua conta';
                $description_login = 'Entre agora para sua conta e comece a divulgar seus APP e Temas!';
                $word_password = 'Senha ';
                $word_forgot_pssw = 'Esqueceu sua senha?';
                $word_remember_user = ' Lembre-se de nome de usuário e senha';
                $word_click_here = 'Clique aqui!';
                $word_transaction_history = 'Histórico de transações ';
                $word_favorate = 'Favoritos';
                $word_enter_username = 'Digite seu Login aqui ...';
                $word_enter_pass = 'Digite sua Senha aqui ...';
                $word_invalid_login = 'Login ou Senha Inválidos';
                $word_sucess_login = 'Login efetuado com Sucesso';
                $word_email_invalid = 'E-mail inválido';
                $word_passwd_invalid = 'Senha inválida';
                $word_profile_author = 'Perfil do Autor';
                $word_member_since = 'Membro desde:';
                $word_total_sales = 'Total de Vendas';
                $word_author_itens = 'Itens do Autor';
                $word_author_badges = 'Badges do Autor';
                $word_recommended = 'Recomendado';
                $word_see_all_items = 'Ver Todos os itens ';
                $word_lastes_items = 'Itens Recentes';
                $word_see_all_message = 'Ver todas as Mensagens';
                $word_lastes_message = 'Últimas Mensagens';
                $word_buyer = 'COMPRADOR';
                $word_read_all_reviews = 'Ler Todos os Comentários';
                $word_comments = 'Comentários';
                $word_your_account = 'Sua Conta';
                $word_info_account = 'Informações da Conta';
                $word_tool_acoount = 'Ferramentas da Conta';
                $word_your_dashboard = 'Seu Painel';
                $word_profile_info = 'Informações de Perfil';
                $word_profile_image = 'Foto de Perfil';
                $word_country = 'País';
                $word_name = 'Nome';
                $word_account_name = 'Nome da Conta';
                $word_enter_name = 'Informe seu nome';
                $word_new_password = 'Nova Senha';
                $word_repeat_password = 'Repita a Senha';
                $word_select_country = 'Selecione seu País...';
                $word_enter_repeat_pss = 'Repita sua Senha aqui ...';
                $word_enter_email = 'Insira seu endereço de email aqui ...';
                $word_enter_website = 'Insira o link do seu website aqui ...';
                $word_about_you = 'Sobre Você';
                $word_describe_you = 'Descreva sobre você (max 140 caracteres)';
                $word_upload_image = 'Atualizar Imagem...';
                $word_minimun_size = 'Tamanho mínimo';
                $word_save = 'Salvar';
                $word_dashboard = 'Painel de Controle';
                $word_items_sold = 'Itens Vendidos';
                $word_total_earnings = 'Ganhos Totais';
                $word_from_sales = 'com vendas';
                $word_up_to_now = 'até agora';
                $word_all_categories = 'Todas as Categorias';
                $word_product_sourcing = ' Dropshipping/Revenda de produtos';
                $word_marketing = 'Marketing';
                $word_sales = 'Otimização de Vendas';
                $word_social_media = 'Mídias Sociais';
                $word_shipping = 'Soluções de Envio';
                $word_inventory = 'Inventário';
                $word_customer_service = 'Serviço ao Cliente';
                $word_tools = 'Ferramentas e Personalizações';
                $word_reporting = 'Relatórios e Análises';
                $word_sales_channels = 'Canais de Venda';
                $word_art_photography = 'Arte e Fotografia';
                $word_clothing_fashion = 'Modas e Acessórios';
                $word_jewelry_accessories = 'Joalherias e Acessórios';
                $word_electronics = 'Eletrônicos';
                $word_food_drinks = 'Alimentos e Bebidas';
                $word_home_garden = 'Casa e Jardim';
                $word_furniture = 'Móveis e Mobília';
                $word_health_beauty = 'Saúde, Beleza e Perfumaria';
                $word_sports_recreation = 'Esportes e Lazer';
                $word_service = 'Serviços';
                $word_toys_games = 'Infantil e Brinquedos';
                $word_other = 'Outros';
                $word_categories = 'Categorias';
                $word_search_empty = 'A busca está vazia.';
                $word_title_description = 'Descrição';
                $word_title_short_description = 'Descrição curta';
                $word_placeholde_description = 'Você pode usar markdown para melhorar a descrição do seu aplicativo.';
                $word_version = 'Versão';
                $word_version_date = 'Data da versão';
                $word_type_of_app = 'Tipo';
                $word_create_account = 'Crie sua conta';
                $word_account_partner = 'Criar conta como parceiro';
                $word_create_password = 'Criar senha';
                $word_info_create_password = 'Nessa página você poderá criar sua senha para registrar seus itens em nosso Marketplace.';
                $word_verify = 'Verificar';
                $word_installations = 'Instalações';
                $word_install = 'Instalar';
                $word_cancel = 'Cancelar';
                $word_galery = 'Galeria';
                $word_support = 'Suporte';
                $word_installation_title = 'O aplicativo solicita as seguintes autorizações';
                $word_evaluation = 'Avaliações';
                break;
        }
        // array dictionary
        $dictionary = array(
            'title' => $title,
            'subtitle' => $subtitle,
            'welcome' => $welcome,
            'welcome_only' => $welcome_only,
            'e_com' => 'E-Com Plus ',
            'addons' => 'Market',
            'word_partner' => $word_partner,
            'word_details' => $word_details,
            'word_shopkeeper' => $word_shopkeeper,
            'word_app' => $word_app,
            'word_theme' => $word_theme,
            'word_plans' => $word_plans,
            'word_plan' => $word_plan,
            'word_value' => $word_value,
            'word_and' => $word_and,
            'word_yes' => $word_yes,
            'word_close' => $word_close,
            'word_no' => $word_no,
            'word_add' => $word_add,
            'word_remove' => $word_remove,
            'word_authentication' => $word_authentication,
            'word_documentation' => $word_documentation,
            'description_mkp' => $description_mkp,
            'word_login' => 'Login ',
            'word_register' => $word_register,
            'word_search' => $word_search,
            'word_go_item' => $word_go_item,
            'word_favorate_add' => $word_favorate_add,
            'desc_promo_partners' => $desc_promo_partners,
            'desc_promo_store' => $desc_promo_store,
            'word_start' => $word_start,
            'word_now' => $word_now,
            'buy_now' => $buy_now,
            'word_buying' => $word_buying,
            'word_in' => $word_in,
            'word_by' => $word_by,
            'apps_trends' => $apps_trends,
            'themes_trends' => $themes_trends,
            'word_reputation' => $word_reputation,
            'word_language' => $word_language,
            'word_select_category' => $word_select_category,
            'word_name_of_item' => $word_name_of_item,
            'word_max_char' => $word_max_char,
            'word_num_version' => $word_num_version,
            'word_date_version' => $word_date_version,
            'word_description_scopes' => $word_description_scopes,
            'word_search_apps_themes' => $word_search_apps_themes,
            'word_buy_apps' => $word_buy_apps,
            'description_buy_apps' => $description_buy_apps,
            'word_secure_transation' => $word_secure_transation,
            'description_secure_transation' => $description_secure_transation,
            'word_community' => $word_community,
            'description_community' => $description_community,
            'description_mkp_quality' => $description_mkp_quality,
            'word_mkp_quality' => $word_mkp_quality,
            'word_how_works' => $word_how_works,
            'path_images' => $path_images,
            'coin' => 'R',
            'word_apps_store' => $word_apps_store,
            'word_items_found' => $word_items_found,
            'word_not_found' => $word_not_found,
            'word_price' => $word_price,
            'word_paid' => $word_paid,
            'word_free_trial' => $word_free_trial,
            'word_frequency' => $word_frequency,
            'word_themes_store' => $word_themes_store,
            'word_profile_page' => $word_profile_page,
            'word_account_settings' => $word_account_settings,
            'word_change_picture' => $word_change_picture,
            'word_sales_statment' => $word_sales_statment,
            'word_withdrawals' => $word_withdrawals,
            'word_manage_items' => $word_manage_items,
            'word_upload_item' => $word_upload_item,
            'word_submit_item' => $word_submit_item,
            'word_specifications' => $word_specifications,
            'word_login_account' => $word_login_account,
            'description_login' => $description_login,
            'word_password' => $word_password,
            'word_forgot_pssw' => $word_forgot_pssw,
            'word_remember_user' => $word_remember_user,
            'word_click_here' => $word_click_here,
            'word_transaction_history' => $word_transaction_history,
            'word_favorate' => $word_favorate,
            'word_enter_username' => $word_enter_username,
            'word_enter_pass' => $word_enter_pass,
            'word_invalid_login' => $word_invalid_login,
            'word_sucess_login' => $word_sucess_login,
            'word_email_invalid' => $word_email_invalid,
            'word_passwd_invalid' => $word_passwd_invalid,
            'word_profile_author' => $word_profile_author,
            'word_member_since' => $word_member_since,
            'word_total_sales' => $word_total_sales,
            'word_author_items' => $word_author_itens,
            'word_author_badges' => $word_author_badges,
            'word_recommended' => $word_recommended,
            'word_see_all_items' => $word_see_all_items,
            'word_lastes_items' => $word_lastes_items,
            'word_see_all_message' => $word_see_all_message,
            'word_lastes_message' => $word_lastes_message,
            'word_buyer' => $word_buyer,
            'word_read_all_reviews' => $word_read_all_reviews,
            'word_comments' => $word_comments,
            'word_your_account' => $word_your_account,
            'word_info_account' => $word_info_account,
            'word_tool_acoount' => $word_tool_acoount,
            'word_your_dashboard' => $word_your_dashboard,
            'word_profile_info' => $word_profile_info,
            'word_profile_image' => $word_profile_image,
            'word_country' => $word_country,
            'word_name' => $word_name,
            'word_account_name' => $word_account_name,
            'word_enter_name' => $word_enter_name,
            'word_new_password' => $word_new_password,
            'word_repeat_password' => $word_repeat_password,
            'word_select_country' => $word_select_country,
            'word_enter_repeat_pss' => $word_enter_repeat_pss,
            'word_enter_email' => $word_enter_email,
            'word_enter_website' => $word_enter_website,
            'word_about_you' => $word_about_you,
            'word_describe_you' => $word_describe_you,
            'word_upload_image' => $word_upload_image,
            'word_minimun_size' => $word_minimun_size,
            'word_save' => $word_save,
            'word_dashboard' => $word_dashboard,
            'word_items_sold' => $word_items_sold,
            'word_total_earnings' => $word_total_earnings,
            'word_from_sales' => $word_from_sales,
            'word_up_to_now' => $word_up_to_now,
            'word_all_categories' => $word_all_categories,
            'word_product_sourcing' => $word_product_sourcing,
            'word_marketing' => $word_marketing,
            'word_sales' => $word_sales,
            'word_social_media' => $word_social_media,
            'word_shipping' => $word_shipping,
            'word_inventory' => $word_inventory,
            'word_customer_service' => $word_customer_service,
            'word_accounting' => $word_accounting,
            'word_tools' => $word_tools,
            'word_reporting' => $word_reporting,
            'word_sales_channels' => $word_sales_channels,
            'word_art_photography' => $word_art_photography,
            'word_clothing_fashion' => $word_clothing_fashion,
            'word_jewelry_accessories' => $word_jewelry_accessories,
            'word_electronics' => $word_electronics,
            'word_food_drinks' => $word_food_drinks,
            'word_home_garden' => $word_home_garden,
            'word_furniture' => $word_furniture,
            'word_health_beauty' => $word_health_beauty,
            'word_sports_recreation' => $word_sports_recreation,
            'word_toys_games' => $word_toys_games,
            'word_service' => $word_service,
            'word_games' => 'Games',
            'word_sexshop' => 'SexShop',
            'word_petshop' => 'PetShop',
            'word_fitness' => 'Fitness',
            'word_other' => $word_other,
            'word_categories' => $word_categories,
            'word_search_empty' => $word_search_empty,
            'word_description_single' => $word_title_description,
            'word_title_short_description' => $word_title_short_description,
            'word_placeholde_description' => $word_placeholde_description,
            'word_version' => $word_version,
            'word_version_date' => $word_version_date,
            'word_type_of_app' => $word_type_of_app,
            'word_create_account' => $word_create_account,
            'word_account_partner' => $word_account_partner,
            'word_create_password' => $word_create_password,
            'word_info_create_password' => $word_info_create_password,
            'word_verify' => $word_verify,
            'word_installations' => $word_installations,
            'word_install' => $word_install,
            'word_cancel' => $word_cancel,
            'word_galery' => $word_galery,
            'word_support' => $word_support,
            'word_installation_title' => $word_installation_title,
            'word_evaluation' => $word_evaluation,
            'lang' => $lang,
        );
        return $dictionary;
    }
}
