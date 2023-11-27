<template>
	<div>
		<section class="dashboard-container">
			<!-- Hero head: will stick at the top -->
			<div class="logo-container">

				<img src="/img/event_app_logo.png" class="logo"/>

				<div class="has-text-centered is-size-4 has-text-weight-bold">EVENT MANAGER PANEL</div>
			</div>
		</section>
		
	</div>
</template>

<script>
export default {

}
</script>

<style scoped>
 /* .hero{
    background-image: url("/img/bg-hero.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}  */

.logo{
	width: 500px;
}
.dashboard-container{
	height: calc(100vh - 10vh);
	display: flex;
	justify-content: center;
	align-items: center;
}


</style>