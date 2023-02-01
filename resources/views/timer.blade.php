
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="{{ asset('css/timer.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1aedbe0b8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://sdk.twilio.com/js/video/releases/2.22.1/twilio-video.min.js"></script>
    <!-- <script src="//sdk.twilio.com/js/video/releases/2.24.3/twilio-video.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <title>Freshman Pomodoro Clock Demo</title>
  </head>
  <body>
    <main class="app">
      <progress id="js-progress" value="0"></progress>
      <div class="progress-bar"></div>
      <div class="timer">
        <div class="button-group mode-buttons" id="js-mode-buttons">
          <button data-mode="pomodoro" class="button active mode-button" id="js-pomodoro">Pomodoro</button>
          <button data-mode="shortBreak" class="button mode-button" id="js-short-break">Short break</button>
          <button data-mode="longBreak" class="button mode-button"id="js-long-break">Long break</button>
        </div>
        <div class="clock" id="js-clock">
          <span id="js-minutes">25</span>
          <span class="separator">:</span>
          <span id="js-seconds">00</span>
        </div>
        <button class="main-button" data-action="start" id="js-btn">Start</button>
      </div>
    </main>
    <script>
      const timer = {pomodoro: 1,shortBreak: 2,longBreak: 3,longBreakInterval: 4,sessions: 0,};
      let interval;
      const rName = "test";
      const mainButton = document.getElementById('js-btn');
      mainButton.addEventListener('click', () => {
        const { action } = mainButton.dataset;
        if (action === 'start') {
          axios.post('/join/' + rName + '/statusTimer',{
            roomName: rName,
            time: timer.workTime,
            action: 'start',
          }).then((_) => {
            iziToast.success({                    
                message: 'Host has Started Timer.',
                position: 'bottomRight'                        
            });
            startTimer();
          }).catch((error) => {
            console.log(error);
          })
        } else {  
          axios.post('/join/' + rName + '/statusTimer',{
            roomName: rName,
            action: 'stop',
          }).then((_) => {
              iziToast.success({                    
                  message: 'Host has stopped Timer.',
                  position: 'bottomRight'                        
              });
              stopTimer(); 
          })
        }
      });

      const modeButtons = document.querySelector('#js-mode-buttons');
      modeButtons.addEventListener('click', handleMode);
      
      function getRemainingTime(endTime) {
        const currentTime = Date.parse(new Date());
        const difference = endTime - currentTime;
        console.log(difference + " = " + endTime +" in " + currentTime);
        const total = Number.parseInt(difference / 1000, 10);
        const minutes = Number.parseInt((total / 60) % 60, 10);
        const seconds = Number.parseInt(total % 60, 10);

        return {total,minutes,seconds,};
      }

      function getEndTime(){
        let promise = axios.get('/join/' + rName + '/getSyncTimer');
        promise.then(function(response) {
          console.log(response.data.endTime);
          return response.data.endTime;
        })
        .catch(function(error) {
          console.error(error);
        });

      }
      
      function startTimer() {
        console.log("startTimerCalled");
        axios.get('/join/' + rName + '/getSyncTimer').then(function(response) {
          console.log("Over Here: "+ response.data);
        })
        .catch(function(error) {
          console.error(error);
        });

        let { total } = timer.remainingTime;
        let test1 = new Date();
        const endTime = Date.parse(new Date()) + total * 1000;
        console.log("Date: "+ test1 +" ---> "+ endTime);
        if (timer.mode === 'pomodoro') timer.sessions++;
      
        mainButton.dataset.action = 'stop';
        mainButton.textContent = 'stop';
        mainButton.classList.add('active');
      
        interval = setInterval(function() {
          timer.remainingTime = getRemainingTime(endTime);
          updateClock();
      
          total = timer.remainingTime.total;
          if (total <= 0) {
            clearInterval(interval);
      
            switch (timer.mode) {
              case 'pomodoro':
                if (timer.sessions % timer.longBreakInterval === 0) {
                  switchMode('longBreak');
                } else {
                  switchMode('shortBreak');
                }
                break;
              default:
                switchMode('pomodoro');
            }
      
            if (Notification.permission === 'granted') {
              const text = timer.mode === 'pomodoro' ? 'Get back to work!' : 'Take a break!';
              new Notification(text);
            }
      
            document.querySelector(`[data-sound="${timer.mode}"]`).play();
            startTimer();
          }
        }, 1000);
      }
      
      function stopTimer() {
        clearInterval(interval);
      
        mainButton.dataset.action = 'start';
        mainButton.textContent = 'start';
        mainButton.classList.remove('active');
      }
      
      function updateClock() {
        const { remainingTime } = timer;
        const minutes = `${remainingTime.minutes}`.padStart(2, '0');
        const seconds = `${remainingTime.seconds}`.padStart(2, '0');
      
        const min = document.getElementById('js-minutes');
        const sec = document.getElementById('js-seconds');
        min.textContent = minutes;
        sec.textContent = seconds;
      
        const text =timer.mode === 'pomodoro' ? 'Get back to work!' : 'Take a break!';
        document.title = `${minutes}:${seconds} — ${text}`;
      
        const progress = document.getElementById('js-progress');
        progress.value = timer[timer.mode] * 60 - timer.remainingTime.total;
      }
      
      function switchMode(mode) {
        timer.mode = mode;
        timer.remainingTime = {total: timer[mode] * 60,minutes: timer[mode],seconds: 0,};

        axios.post('/join/' + rName + '/updateTimer',{
          roomName: rName,
          mode: mode,
        }).then(function(response){
          console.log("Successfully Changed: " + mode +" in " + rName);
        });
      
        document.querySelectorAll('button[data-mode]').forEach(e => e.classList.remove('active'));
        document.querySelector(`[data-mode="${mode}"]`).classList.add('active');
        document.body.style.backgroundColor = `var(--${mode})`;
        document.getElementById('js-progress').setAttribute('max', timer.remainingTime.total);
      
        updateClock();
      }
      
      function handleMode(event) {
        const { mode } = event.target.dataset;
      
        if (!mode) return;
      
        switchMode(mode);
        stopTimer();
      }
      
      document.addEventListener('DOMContentLoaded', () => {
        if ('Notification' in window) {
          if (Notification.permission !== 'granted' && Notification.permission !== 'denied'){
            Notification.requestPermission().then(function(permission) {
              if (permission === 'granted') {
                new Notification('Awesome! You will be notified at the start of each session');
              }
            });
          }
        }
        switchMode('pomodoro');
      });
    </script>
  </body>
</html>
 