#documation for client side

1. Include the socket.io.js to your document. You can get and read the documantation here (https://socket.io/docs/client-api/);
	<script src="/plugin/Socket/socket.io.js"></script>
2. Initialize socket.io (not the ip and port should defending on the server setup/ip setup)
    <script type="text/javascript">
   		const socket = io('127.0.01:3001', {secure: true, rejectUnauthorized : false});

3. 	Subscribe to the channel (read the bottom for the list of channel and events per channel)

	socket.on("Daisumi-item", function(event){
       	// event (json object)
       	// event.event (string)
       	// event.data (json object)
        console.log('Event Name:', event.event);
        console.log('Event Data:', event.data);
    });

4. List of channels:
	* 	Daisumi-banner
			Events:
				-NewBanner
				-UpdateBanner
				-ArchiveBanner
	* 	Daisumi-bundle
				-NewBundle
				-UpdateBundle
				-ArchiveBundle
	*	Daisumi-category
				-NewCategory
				-UpdateCategory
				-ArchiveCategory
	*	Daisumi-item
				-NewItem
				-UpdateItem
				-ArchiveItem
	*	Daisumi-item-images
				-NewItemImage
				-UpdateItemImage
				-ArchiveItemImage
	*	Daisumi-item-tags
				-NewItemTags
				-UpdateItemTags
				-ArchiveItemTags
	*	Daisumi-video
				-NewVideo
				-UpdateVideo
				-ArchiveVideo
	*	Daisumi-voucher
				-NewVoucher
				-UpdateVoucher
				-ArchiveVoucher
	*	Daisumi-voucher-type
				-NewVoucherType
				-UpdateVoucherType
				-ArchiveVoucherType
	*	Daisumi






