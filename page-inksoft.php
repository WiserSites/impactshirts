<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
Template Name: Designer
 */

get_header(); ?>
<style>
#container, #wrapper {
	background-color:#F2F2F2;	
}
</style>

<div>
    <script type="text/javascript" language="javascript" src="https://stores.inksoft.com/designer/html5/common/js/launcher.js"></script>
    <div align="center" id="embeddedDesigner">
<div class="whiteLabelHack"></div></div>
    <script type="text/javascript" language="javascript">
        var flashvars = {
EnforceBoundaries: "0",
Background: "",
VectorOnly: true,
DigitalPrint: false,
ScreenPrint: true,
Embroidery: false,
MaxScreenPrintColors: "6",
StoreID: "16024",
PublisherID: "3411",
SessionID: "",
SessionToken: "",
UserID: "",
UserName: "",
UserEmail: "",
ProductID: "1000000",
ProductStyleID: "1000043",
ProductCategoryID: "1000001",
DesignID: "",
ArtID: "",
EnableBranding: false,
DisableUploadImage: false,
DisableAddToCart: false,
DisableClipArt: false,
DisableUserArt: false,
DisableProducts: false,
DisableDesigns: false,
DisableDistress: true,
StartPage: "Products",
StartPageCategoryID: "",
StartPageHTML: "",
ClipArtGalleryID: "",
Domain: "stores.inksoft.com",
SSLEnabled: true,
SSLDomain: "stores.inksoft.com",
StoreURI: "Ministry_Gear",
DefaultProductID: "1000000",
DefaultProductStyleID: "1000043",
DisableResolutionMeter: true,
DisableUploadVectorArt: false,
DisableUploadRasterArt: false,
Admin: "None",
NextURL: "",
CartURL: "/Ministry_Gear/Cart",
OrderSummary: true,
Phone: "818-366-1988",
VideoLink: "http://www.youtube.com/watch?v=EfXICdRwt4E",
WelcomeScreen: "",
ContactUsLink: "https://stores.inksoft.com/Ministry_Gear/Stores/Contact",
WelcomeVideo: "",
HelpVideoOverview: "",
GreetBoxSetting: "LANDING",
AutoZoom: false,
EnableNameNumbers: true,
AddThisPublisherId: "xa-4fccb0966fef0ba7",
EnableCartPricing: true,
EnableCartCheckout: true,
EnableCartBilling: false,
PaymentDisabled: false,
PaymentRequired: true,
BillingAddressRequired: true,
EnableCartShipping: true,
PasswordLength: "",
CurrencyCode: "USD",
CurrencySymbol: "$",
HideProductPricing: false,
HideClipArtNames: true,
HideDesignNames: true,
DesignerLocation: "http://stores.inksoft.com/designer/html5",
ThemeName: "flat",
EmbedType: "iframe",
BackgroundColor: ""};
        launchDesigner('HTML5DS', flashvars, document.getElementById("embeddedDesigner"));
    </script>
	<h4 style="text-align:center; position:relative; margin-top:-60px;">Need help? Call a designer at 888.812.4044</h4>
</div>
<?php get_footer(); ?>