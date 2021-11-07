@extends('layouts.layoutfront')
@section('content')
    <div class="filters">
        <ul>
            <li><button>Date</button></li>
            <li><button>All Events</button></li>
            <li><button>Football</button></li>
            <li><button>Basketball</button></li>
            <li><button>Baseball</button></li>
            <li><button>Volleyball</button></li>
            <li><button>Soccer</button></li>
        </ul>
    </div>
    <div class="results">
        <div class="results__event">
            <div class="results__event__header">
                <div class="results__event__header__logo">
                    <img src="{{asset('image/adams-state-logo.png')}}">
                </div>
                <div class="results__event__header__info ">
                    <h5>Skyhawks vs. Adams State University</h5>
                    <p>Football - Thursday, May 6 @ 6:30pm - Ray Dennison Memorial Field - Durango, CO</p>
                </div>
                <button class="results__event__header__toggle eventAccordionToggle">
                    Tickets <i class="fas fa-angle-down"></i>
                </button>
            </div>
            <div class="results__event__body" id="eventBody">
                <div class="results__event__body__ticket">
                    <span>General Admission | $10</span>
                    <div class="results__event__body__ticket__ecommerce">
                        <label>QTY:</label>
                        <input type="number" id="quantity" name="quantity" min="1">
                        <button>Add to cart</button>
                    </div>
                </div>
                <div class="results__event__body__ticket">
                    <span>High School Student | $5</span>
                    <div class="results__event__body__ticket__ecommerce">
                        <label>QTY:</label>
                        <input type="number" id="quantity" name="quantity" min="1">
                        <button>Add to cart</button>
                    </div>
                </div>
                <div class="results__event__body__ticket">
                    <span>Player Pass | $5</span>
                    <div class="results__event__body__ticket__ecommerce">
                        <label>QTY:</label>
                        <input type="number" id="quantity" name="quantity" min="1">
                        <button>Add to cart</button>
                    </div>
                </div>
                <div class="results__event__body__ticket">
                    <span>Senior Citizen (65+) | $5</span>
                    <div class="results__event__body__ticket__ecommerce">
                        <label>QTY:</label>
                        <input type="number" id="quantity" name="quantity" min="1">
                        <button>Add to cart</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="results__event">
            <div class="results__event__header">
                <div class="results__event__header__logo">
                    <img src="{{asset('image/adams-state-logo.png')}}">
                </div>
                <div class="results__event__header__info">
                    <h5>Skyhawks vs. Adams State University</h5>
                    <p>Football - Thursday, May 6 @ 6:30pm - Ray Dennison Memorial Field - Durango, CO</p>
                </div>
                <button class="results__event__header__toggle eventAccordionToggle">
                    Tickets <i class="fas fa-angle-down"></i>
                </button>
            </div>
            <div class="results__event__body" id="eventBody">
                <div class="results__event__body__ticket">
                    <span>General Admission | $10</span>
                    <div class="results__event__body__ticket__ecommerce">
                        <label>QTY:</label>
                        <input type="number" id="quantity" name="quantity" min="1">
                        <button>Add to cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection