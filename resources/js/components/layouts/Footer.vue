<template>
    <footer class="py-3 bg-light mt-auto dash-foot">
     <div class="container">
         <div class="d-flex align-items-center justify-content-between small">
             <div class="text-muted">
                {{$moment().format("Y") }} © All rights reserved by 
             </div>
             <div>
                 <p class="m-0">
                     Designed & Developed by<a target="_blank" href="#">
                         </a>
                 </p>
             </div>
         </div>
     </div>
 </footer>
</template>

<script>
export default {
    name:'Footer'
}
</script>