import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  meId = null;
  eventSource = null;

  initialize() {
    this.meId = +this.data.get('me');
    this.initEventSource();
  }

  connect() {
  }

  initEventSource() {
    // to see the eventStream open network tab in browser, filter by 'mercure' and click on the mercure call 
    console.log(this.data.get('mercure'));
    this.eventSource = new EventSource(this.data.get('mercure'));
    this.eventSource.onmessage = (e) => this.onMercureMessage(e);
  }

  onMercureMessage(event) {
    const data = JSON.parse(event.data);
    console.log(data);
  }
}
