// Simple Chat Widget JavaScript

// Wait for the page to fully load
document.addEventListener('DOMContentLoaded', function() {

    // Find the chat icon button
    var chatButton = document.getElementById('chatIconButton');

    // Find the chat window
    var chatWindow = document.getElementById('chatWindow');

    // Find the close button
    var closeButton = document.getElementById('chatCloseButton');

    // Find the send button
    var sendButton = document.getElementById('chatSendButton');

    // Find the input field
    var messageInput = document.getElementById('chatMessageInput');

    // Find the messages container
    var messagesContainer = document.getElementById('chatMessages');

    // Find the preset buttons container
    var presetButtonsContainer = document.getElementById('presetButtons');

    // Find all preset buttons
    var presetButtons = document.querySelectorAll('.preset-button');

    // Find image attachment elements
    var attachButton = document.getElementById('chatAttachButton');
    var imageInput = document.getElementById('chatImageInput');
    var imagePreview = document.getElementById('chatImagePreview');
    var previewImage = document.getElementById('previewImage');
    var removePreviewBtn = document.getElementById('removePreview');

    // Variable to store selected image
    var selectedImage = null;

    // Function to open the chat window
    function openChat() {
        // Add 'open' class to show the chat window
        chatWindow.classList.add('open');

        // Add 'hidden' class to hide the chat icon button
        chatButton.classList.add('hidden');
    }

    // Function to close the chat window
    function closeChat() {
        // Remove 'open' class to hide the chat window
        chatWindow.classList.remove('open');

        // Remove 'hidden' class to show the chat icon button again
        chatButton.classList.remove('hidden');
    }

    // Function to send a message
    function sendMessage() {
        // Get the text from the input field
        var messageText = messageInput.value;

        // Check if we have either a message or an image
        if (messageText.trim() !== '' || selectedImage) {
            // If we have a selected branch (live chat mode), send to server
            if (window.selectedBranchId) {
                sendRealTimeMessage(messageText);
            } else {
                // Regular bot message display (only if there's text)
                if (messageText.trim() !== '') {
                    // Create a new div element for the message
                    var messageDiv = document.createElement('div');

                    // Add the 'chat-message' class to style it
                    messageDiv.className = 'chat-message';

                    // Put the message text inside the div
                    messageDiv.textContent = messageText;

                    // Add the message to the messages container
                    messagesContainer.appendChild(messageDiv);

                    // Scroll to bottom to see the new message
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }

            // Clear the input field
            messageInput.value = '';

            // Hide preset buttons after first message is sent
            if (presetButtonsContainer) {
                presetButtonsContainer.classList.add('hidden');
            }
        }
    }

    // Function to handle preset button clicks
    function handlePresetButtonClick(event) {
        // Get the button that was clicked
        var button = event.target;

        // Get the message text from the button's data-message attribute
        var messageText = button.getAttribute('data-message');

        // Create a new div for the user's message
        var messageDiv = document.createElement('div');
        messageDiv.className = 'chat-message';
        messageDiv.textContent = messageText;

        // Add the message to the chat
        messagesContainer.appendChild(messageDiv);

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Hide all preset buttons after clicking one
        presetButtonsContainer.classList.add('hidden');

        // Check which button was clicked and show appropriate response
        if (messageText === 'What are your services?') {
            // Show service categories after short delay
            setTimeout(function() {
                showServiceCategories();
            }, 500);
        } else if (messageText === 'What are your branch opening hours?') {
            // Show branch hours after short delay
            setTimeout(function() {
                showBranchHours();
            }, 500);
        } else if (messageText === 'I need to talk to staff') {
            // Show branch selection for talking to staff
            setTimeout(function() {
                showBranchSelection();
            }, 500);
        } else {
            // For other buttons, show default response
            setTimeout(function() {
                var responseDiv = document.createElement('div');
                responseDiv.className = 'chat-message';
                responseDiv.textContent = 'Thank you for your message!';
                messagesContainer.appendChild(responseDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }, 500);
        }
    }

    // Function to show service categories
    function showServiceCategories() {
        // Hide any existing category buttons first
        var existingCategoryButtons = document.getElementById('categoryButtons');
        if (existingCategoryButtons) {
            existingCategoryButtons.remove();
        }

        // Create response message
        var responseDiv = document.createElement('div');
        responseDiv.className = 'chat-message';
        responseDiv.textContent = 'Please select a service category:';
        messagesContainer.appendChild(responseDiv);

        // Show loading message
        var loadingDiv = document.createElement('div');
        loadingDiv.className = 'chat-message';
        loadingDiv.textContent = 'Loading categories...';
        loadingDiv.id = 'loadingCategories';
        messagesContainer.appendChild(loadingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Fetch categories from API
        fetch('/api/chat/categories')
            .then(function(response) {
                console.log('Categories API response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Categories data received:', data);
                // Remove loading message
                var loadingElement = document.getElementById('loadingCategories');
                if (loadingElement) {
                    loadingElement.remove();
                }

                if (data.success && data.categories && data.categories.length > 0) {
                    // Create category buttons container
                    var categoryButtonsDiv = document.createElement('div');
                    categoryButtonsDiv.className = 'preset-buttons';
                    categoryButtonsDiv.id = 'categoryButtons';

                    // Loop through categories from API and create buttons
                    for (var i = 0; i < data.categories.length; i++) {
                        var categoryButton = document.createElement('button');
                        categoryButton.className = 'preset-button';
                        categoryButton.textContent = '💆 ' + data.categories[i];
                        categoryButton.setAttribute('data-category', data.categories[i]);

                        // Add click event to each category button
                        categoryButton.addEventListener('click', function(event) {
                            handleCategoryClick(event);
                        });

                        categoryButtonsDiv.appendChild(categoryButton);
                    }

                    // Add category buttons to chat
                    messagesContainer.appendChild(categoryButtonsDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                } else {
                    // No categories found
                    var errorDiv = document.createElement('div');
                    errorDiv.className = 'chat-message';
                    errorDiv.textContent = 'Sorry, no service categories available at the moment.';
                    messagesContainer.appendChild(errorDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            })
            .catch(function(error) {
                // Remove loading message
                var loadingElement = document.getElementById('loadingCategories');
                if (loadingElement) {
                    loadingElement.remove();
                }

                // Show error message
                var errorDiv = document.createElement('div');
                errorDiv.className = 'chat-message';
                errorDiv.textContent = 'Sorry, unable to load categories. Please try again later.';
                messagesContainer.appendChild(errorDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                console.error('Error fetching categories:', error);
            });
    }

    // Function to show branch opening hours
    function showBranchHours() {
        // Create response message
        var responseDiv = document.createElement('div');
        responseDiv.className = 'chat-message';
        responseDiv.textContent = 'Here are our branch operating hours:';
        messagesContainer.appendChild(responseDiv);

        // Show loading message
        var loadingDiv = document.createElement('div');
        loadingDiv.className = 'chat-message';
        loadingDiv.textContent = 'Loading branch hours...';
        loadingDiv.id = 'loadingBranchHours';
        messagesContainer.appendChild(loadingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Fetch branch hours from API
        fetch('/api/chat/branch-hours')
            .then(function(response) {
                console.log('Branch hours API response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Branch hours data received:', data);
                // Remove loading message
                var loadingElement = document.getElementById('loadingBranchHours');
                if (loadingElement) {
                    loadingElement.remove();
                }

                if (data.success && data.branches && data.branches.length > 0) {
                    // Loop through each branch and display its hours
                    for (var i = 0; i < data.branches.length; i++) {
                        var branch = data.branches[i];

                        // Create branch info div
                        var branchDiv = document.createElement('div');
                        branchDiv.className = 'chat-message branch-hours';

                        // Build the HTML for branch hours
                        var branchHTML = '<div class="branch-info">';
                        branchHTML += '<div class="branch-name">📍 ' + branch.name + '</div>';
                        branchHTML += '<div class="branch-address">' + branch.address + '</div>';
                        branchHTML += '<div class="branch-hours">⏰ ' + branch.hours + '</div>';
                        branchHTML += '<div class="branch-days">📅 ' + branch.days.join(', ') + '</div>';
                        if (branch.contact) {
                            branchHTML += '<div class="branch-contact">📞 ' + branch.contact + '</div>';
                        }
                        branchHTML += '</div>';

                        branchDiv.innerHTML = branchHTML;
                        messagesContainer.appendChild(branchDiv);
                    }

                    // Show original preset buttons again after short delay
                    setTimeout(function() {
                        showOriginalPresetButtons();
                    }, 500);

                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                } else {
                    // No branches found
                    var errorDiv = document.createElement('div');
                    errorDiv.className = 'chat-message';
                    errorDiv.textContent = 'Sorry, no branch information available at the moment.';
                    messagesContainer.appendChild(errorDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;

                    // Show original preset buttons again
                    setTimeout(function() {
                        showOriginalPresetButtons();
                    }, 500);
                }
            })
            .catch(function(error) {
                // Remove loading message
                var loadingElement = document.getElementById('loadingBranchHours');
                if (loadingElement) {
                    loadingElement.remove();
                }

                // Show error message
                var errorDiv = document.createElement('div');
                errorDiv.className = 'chat-message';
                errorDiv.textContent = 'Sorry, unable to load branch hours. Please try again later.';
                messagesContainer.appendChild(errorDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                console.error('Error fetching branch hours:', error);

                // Show original preset buttons again
                setTimeout(function() {
                    showOriginalPresetButtons();
                }, 500);
            });
    }

    // Function to handle category button clicks
    function handleCategoryClick(event) {
        // Get the button that was clicked
        var button = event.target;

        // Get the category name
        var categoryName = button.getAttribute('data-category');

        // Show user's selection as a message
        var userMessageDiv = document.createElement('div');
        userMessageDiv.className = 'chat-message';
        userMessageDiv.textContent = categoryName;
        messagesContainer.appendChild(userMessageDiv);

        // Hide category buttons
        var categoryButtons = document.getElementById('categoryButtons');
        if (categoryButtons) {
            categoryButtons.classList.add('hidden');
        }

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Show services for selected category after short delay
        setTimeout(function() {
            showServicesForCategory(categoryName);
        }, 500);
    }

    // Function to show services for a category
    function showServicesForCategory(categoryName) {
        // Create response message
        var responseDiv = document.createElement('div');
        responseDiv.className = 'chat-message';
        responseDiv.textContent = 'Here are our ' + categoryName + ' services:';
        messagesContainer.appendChild(responseDiv);

        // Show loading message
        var loadingDiv = document.createElement('div');
        loadingDiv.className = 'chat-message';
        loadingDiv.textContent = 'Loading services...';
        loadingDiv.id = 'loadingServices';
        messagesContainer.appendChild(loadingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Fetch services from API
        fetch('/api/chat/services/' + encodeURIComponent(categoryName))
            .then(function(response) {
                console.log('Services API response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Services data received:', data);
                // Remove loading message
                var loadingElement = document.getElementById('loadingServices');
                if (loadingElement) {
                    loadingElement.remove();
                }

                if (data.success && data.services && data.services.length > 0) {
                    // Create services list message
                    var servicesListDiv = document.createElement('div');
                    servicesListDiv.className = 'chat-message services-list';

                    // Build the services list HTML
                    var servicesHTML = '';
                    for (var i = 0; i < data.services.length; i++) {
                        servicesHTML += '<div class="service-item">';
                        servicesHTML += '<span class="service-name">' + data.services[i].name + '</span>';
                        servicesHTML += '<span class="service-price">' + data.services[i].price + '</span>';
                        servicesHTML += '</div>';
                    }

                    servicesListDiv.innerHTML = servicesHTML;
                    messagesContainer.appendChild(servicesListDiv);

                    // Show original preset buttons again after short delay
                    setTimeout(function() {
                        showOriginalPresetButtons();
                    }, 500);

                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                } else {
                    // No services found
                    var errorDiv = document.createElement('div');
                    errorDiv.className = 'chat-message';
                    errorDiv.textContent = 'Sorry, no services available in this category at the moment.';
                    messagesContainer.appendChild(errorDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;

                    // Show original preset buttons again
                    setTimeout(function() {
                        showOriginalPresetButtons();
                    }, 500);
                }
            })
            .catch(function(error) {
                // Remove loading message
                var loadingElement = document.getElementById('loadingServices');
                if (loadingElement) {
                    loadingElement.remove();
                }

                // Show error message
                var errorDiv = document.createElement('div');
                errorDiv.className = 'chat-message';
                errorDiv.textContent = 'Sorry, unable to load services. Please try again later.';
                messagesContainer.appendChild(errorDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                console.error('Error fetching services:', error);

                // Show original preset buttons again
                setTimeout(function() {
                    showOriginalPresetButtons();
                }, 500);
            });
    }

    // Function to show branch selection for "Talk to Staff"
    function showBranchSelection() {
        // Create response message
        var responseDiv = document.createElement('div');
        responseDiv.className = 'chat-message';
        responseDiv.textContent = 'Please select which branch you want to connect with:';
        messagesContainer.appendChild(responseDiv);

        // Show loading message
        var loadingDiv = document.createElement('div');
        loadingDiv.className = 'chat-message';
        loadingDiv.textContent = 'Loading branches...';
        loadingDiv.id = 'loadingBranches';
        messagesContainer.appendChild(loadingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Fetch branches from API
        fetch('/api/chat/branch-hours')
            .then(function(response) {
                console.log('Branches API response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Branches data received:', data);
                // Remove loading message
                var loadingElement = document.getElementById('loadingBranches');
                if (loadingElement) {
                    loadingElement.remove();
                }

                if (data.success && data.branches && data.branches.length > 0) {
                    // Create branch buttons container
                    var branchButtonsDiv = document.createElement('div');
                    branchButtonsDiv.className = 'preset-buttons';
                    branchButtonsDiv.id = 'branchButtons';

                    // Loop through branches and create buttons
                    for (var i = 0; i < data.branches.length; i++) {
                        var branchButton = document.createElement('button');
                        branchButton.className = 'preset-button';
                        branchButton.textContent = '🏢 ' + data.branches[i].name;
                        branchButton.setAttribute('data-branch-id', data.branches[i].id);
                        branchButton.setAttribute('data-branch-name', data.branches[i].name);

                        // Add click event to each branch button
                        branchButton.addEventListener('click', function(event) {
                            handleBranchClick(event);
                        });

                        branchButtonsDiv.appendChild(branchButton);
                    }

                    // Add branch buttons to chat
                    messagesContainer.appendChild(branchButtonsDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                } else {
                    // No branches found
                    var errorDiv = document.createElement('div');
                    errorDiv.className = 'chat-message';
                    errorDiv.textContent = 'Sorry, no branches available at the moment.';
                    messagesContainer.appendChild(errorDiv);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            })
            .catch(function(error) {
                // Remove loading message
                var loadingElement = document.getElementById('loadingBranches');
                if (loadingElement) {
                    loadingElement.remove();
                }

                console.error('Error fetching branches:', error);
                var errorDiv = document.createElement('div');
                errorDiv.className = 'chat-message';
                errorDiv.textContent = 'Sorry, there was an error loading branches. Please try again.';
                messagesContainer.appendChild(errorDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
    }

    // Function to handle branch selection
    function handleBranchClick(eventOrId, branchNameParam) {
        var branchId, branchName;

        // Check if called from event or directly with parameters
        if (typeof eventOrId === 'object' && eventOrId.target) {
            // Called from event
            var button = eventOrId.target;
            branchId = button.getAttribute('data-branch-id');
            branchName = button.getAttribute('data-branch-name');
        } else {
            // Called directly with branchId and branchName
            branchId = eventOrId;
            branchName = branchNameParam;
        }

        // Show user's selection
        var userMessageDiv = document.createElement('div');
        userMessageDiv.className = 'chat-message';
        userMessageDiv.textContent = 'Connect with ' + branchName;
        messagesContainer.appendChild(userMessageDiv);

        // Remove branch buttons if they exist
        var branchButtons = document.getElementById('branchButtons');
        if (branchButtons) {
            branchButtons.remove();
        }

        // Show response
        var responseDiv = document.createElement('div');
        responseDiv.className = 'chat-message';
        responseDiv.textContent = 'Connecting you with ' + branchName + ' staff. Please type your message below:';
        messagesContainer.appendChild(responseDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Store the selected branch ID for future messages
        window.selectedBranchId = branchId;

        // Initialize Pusher connection for this branch
        initializePusherForBranch(branchId);

        // Load chat history for this branch
        loadChatHistory(branchId);

        // Enable the message input for live chat
        messageInput.placeholder = 'Type your message to ' + branchName + ' staff...';
        messageInput.focus();
    }

    // Expose handleBranchClick globally so it can be called from messages page
    window.handleBranchClick = handleBranchClick;

    // Expose openChat function globally so it can be called from messages page
    window.openChatWidget = openChat;

    // Function to show the original preset buttons again
    function showOriginalPresetButtons() {
        // Create response message
        var responseDiv = document.createElement('div');
        responseDiv.className = 'chat-message';
        responseDiv.textContent = 'How else can I help you?';
        messagesContainer.appendChild(responseDiv);

        // Create new preset buttons container
        var newPresetButtonsDiv = document.createElement('div');
        newPresetButtonsDiv.className = 'preset-buttons';
        newPresetButtonsDiv.id = 'newPresetButtons-' + Date.now(); // Unique ID

        // Original preset buttons data
        var presetButtonsData = [
            { emoji: '💆', text: 'View Services', message: 'What are your services?' },
            { emoji: '🕒', text: 'Branch Opening Hours', message: 'What are your branch opening hours?' },
            { emoji: '👤', text: 'Talk to Staff', message: 'I need to talk to staff' }
        ];

        // Loop through and create each button
        for (var i = 0; i < presetButtonsData.length; i++) {
            var button = document.createElement('button');
            button.className = 'preset-button';
            button.textContent = presetButtonsData[i].emoji + ' ' + presetButtonsData[i].text;
            button.setAttribute('data-message', presetButtonsData[i].message);

            // Add click event to button
            button.addEventListener('click', handlePresetButtonClick);

            newPresetButtonsDiv.appendChild(button);
        }

        // Add buttons to chat
        messagesContainer.appendChild(newPresetButtonsDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // When user clicks the chat icon button, open the chat
    chatButton.addEventListener('click', openChat);

    // When user clicks the close button, close the chat
    closeButton.addEventListener('click', closeChat);

    // When user clicks the send button, send the message
    sendButton.addEventListener('click', sendMessage);

    // When user presses Enter key in the input field, send the message
    messageInput.addEventListener('keypress', function(event) {
        // Check if the key pressed is Enter (key code 13)
        if (event.key === 'Enter') {
            sendMessage();
        }
    });

    // Add click listeners to all preset buttons
    // Loop through each preset button
    for (var i = 0; i < presetButtons.length; i++) {
        // Add click event to each button
        presetButtons[i].addEventListener('click', handlePresetButtonClick);
    }

    // ========== IMAGE ATTACHMENT HANDLERS ==========

    // When user clicks attach button, trigger file input
    if (attachButton) {
        attachButton.addEventListener('click', function() {
            imageInput.click();
        });
    }

    // When user selects an image file
    if (imageInput) {
        imageInput.addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                // Check if it's an image file (support multiple formats)
                var validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/svg+xml', 'image/heic', 'image/heif'];
                
                if (!validImageTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, WebP, BMP, SVG, HEIC, HEIF).');
                    imageInput.value = '';
                    return;
                }

                // Check file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Image file is too large. Maximum size is 10MB.');
                    imageInput.value = '';
                    return;
                }

                selectedImage = file;

                // Show preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // When user clicks remove preview button
    if (removePreviewBtn) {
        removePreviewBtn.addEventListener('click', function() {
            selectedImage = null;
            imageInput.value = '';
            imagePreview.style.display = 'none';
            previewImage.src = '';
        });
    }

    // ========== REAL-TIME CHAT FUNCTIONS ==========

    // Function to send real-time message to server
    function sendRealTimeMessage(messageText) {
        // Get CSRF token
        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token not found');
            showErrorMessage('Unable to send message. Please refresh the page.');
            return;
        }

        var tokenValue = csrfToken.getAttribute('content');
        console.log('CSRF Token:', tokenValue);
        console.log('Sending message to branch:', window.selectedBranchId);

        // Check if we have an image attachment
        if (selectedImage) {
            // Use FormData for file upload
            var formData = new FormData();
            formData.append('branch_id', window.selectedBranchId);
            formData.append('message', messageText || '');
            formData.append('sender_type', 'client');
            formData.append('image', selectedImage);

            // Show user's message with image immediately
            var messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message user-message';
            messageDiv.style.backgroundColor = '#e3f2fd';
            messageDiv.style.marginLeft = 'auto';
            messageDiv.style.marginRight = '0';
            messageDiv.style.maxWidth = '80%';

            // Add text if provided
            if (messageText && messageText.trim()) {
                var textSpan = document.createElement('div');
                textSpan.textContent = messageText;
                textSpan.style.marginBottom = '5px';
                messageDiv.appendChild(textSpan);
            }

            // Add image preview to message
            var imgElement = document.createElement('img');
            imgElement.className = 'message-image';
            imgElement.src = URL.createObjectURL(selectedImage);
            imgElement.style.maxWidth = '100%';
            imgElement.style.borderRadius = '8px';
            imgElement.style.marginTop = messageText && messageText.trim() ? '5px' : '0';
            messageDiv.appendChild(imgElement);

            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            // Clear image preview and selection
            selectedImage = null;
            imageInput.value = '';
            imagePreview.style.display = 'none';
            previewImage.src = '';

            // Send to server via API
            fetch('/api/chat/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': tokenValue,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: formData
            })
            .then(function(response) {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(function(errorData) {
                        console.error('Error response:', errorData);
                        throw new Error(errorData.message || 'Failed to send message');
                    });
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Message with image sent successfully:', data);
            })
            .catch(function(error) {
                console.error('Error sending message with image:', error);
                showErrorMessage('Failed to send message with image. ' + error.message);
            });
        } else {
            // No image, send text only (original code)
            // Show user's message immediately
            var messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message user-message';
            messageDiv.style.backgroundColor = '#e3f2fd';
            messageDiv.style.marginLeft = 'auto';
            messageDiv.style.marginRight = '0';
            messageDiv.style.maxWidth = '80%';
            messageDiv.textContent = messageText;
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            // Send to server via API
            fetch('/api/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': tokenValue,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    branch_id: window.selectedBranchId,
                    message: messageText,
                    sender_type: 'client'
                })
            })
            .then(function(response) {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(function(errorData) {
                        console.error('Error response:', errorData);
                        throw new Error(errorData.message || 'Failed to send message');
                    });
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Message sent successfully:', data);
            })
            .catch(function(error) {
                console.error('Error sending message:', error);
                showErrorMessage('Failed to send message. ' + error.message);
            });
        }
    }

    // Function to display incoming staff messages
    function displayStaffMessage(messageData) {
        var messageDiv = document.createElement('div');
        messageDiv.className = 'chat-message staff-message';
        messageDiv.style.backgroundColor = '#f5f5f5';
        messageDiv.style.marginRight = 'auto';
        messageDiv.style.marginLeft = '0';
        messageDiv.style.maxWidth = '80%';

        // Add staff name if available
        var staffName = messageData.staff && messageData.staff.name ? messageData.staff.name : 'Staff';
        var nameSpan = document.createElement('div');
        nameSpan.style.fontSize = '12px';
        nameSpan.style.color = '#666';
        nameSpan.style.marginBottom = '4px';
        nameSpan.textContent = staffName;

        messageDiv.appendChild(nameSpan);

        // Add message text if available
        if (messageData.message && messageData.message.trim()) {
            var textSpan = document.createElement('div');
            textSpan.textContent = messageData.message;
            textSpan.style.marginBottom = messageData.image ? '5px' : '0';
            messageDiv.appendChild(textSpan);
        }

        // Add image if available
        if (messageData.image) {
            var imgElement = document.createElement('img');
            imgElement.className = 'message-image';
            imgElement.style.maxWidth = '100%';
            imgElement.style.borderRadius = '8px';
            imgElement.style.cursor = 'pointer';
            imgElement.style.marginTop = (messageData.message && messageData.message.trim()) ? '5px' : '0';
            // Use image_url if available (with full URL), otherwise fall back to /storage/ path
            imgElement.src = messageData.image_url || ('/storage/' + messageData.image);
            imgElement.alt = 'Attached image';
            imgElement.onclick = function() {
                window.open(this.src, '_blank');
            };
            messageDiv.appendChild(imgElement);
        }

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Mark message as read
        markMessageAsRead(messageData.id);
    }

    // Function to show error message
    function showErrorMessage(errorText) {
        var errorDiv = document.createElement('div');
        errorDiv.className = 'chat-message';
        errorDiv.style.backgroundColor = '#ffebee';
        errorDiv.style.color = '#c62828';
        errorDiv.textContent = errorText;
        messagesContainer.appendChild(errorDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Function to mark message as read
    function markMessageAsRead(messageId) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) return;

        fetch('/api/chat/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                message_ids: [messageId]
            })
        })
        .catch(function(error) {
            console.error('Error marking message as read:', error);
        });
    }

    // Function to load chat history when connecting to a branch
    function loadChatHistory(branchId) {
        fetch('/api/chat/messages?branch_id=' + branchId, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Failed to load chat history');
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success && data.data && data.data.length > 0) {
                // Display chat history
                data.data.forEach(function(message) {
                    if (message.sender_type === 'client') {
                        var messageDiv = document.createElement('div');
                        messageDiv.className = 'chat-message user-message';
                        messageDiv.style.backgroundColor = '#e3f2fd';
                        messageDiv.style.marginLeft = 'auto';
                        messageDiv.style.marginRight = '0';
                        messageDiv.style.maxWidth = '80%';

                        // Add message text if available
                        if (message.message && message.message.trim()) {
                            var textSpan = document.createElement('div');
                            textSpan.textContent = message.message;
                            textSpan.style.marginBottom = message.image ? '5px' : '0';
                            messageDiv.appendChild(textSpan);
                        }

                        // Add image if available
                        if (message.image) {
                            var imgElement = document.createElement('img');
                            imgElement.className = 'message-image';
                            imgElement.style.maxWidth = '100%';
                            imgElement.style.borderRadius = '8px';
                            imgElement.style.cursor = 'pointer';
                            imgElement.style.marginTop = (message.message && message.message.trim()) ? '5px' : '0';
                            // Use image_url if available (with full URL), otherwise fall back to /storage/ path
                            imgElement.src = message.image_url || ('/storage/' + message.image);
                            imgElement.alt = 'Attached image';
                            imgElement.onclick = function() {
                                window.open(this.src, '_blank');
                            };
                            messageDiv.appendChild(imgElement);
                        }

                        messagesContainer.appendChild(messageDiv);
                    } else {
                        displayStaffMessage(message);
                    }
                });
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        })
        .catch(function(error) {
            console.error('Error loading chat history:', error);
        });
    }

    // Initialize Pusher subscription when branch is selected
    function initializePusherForBranch(branchId) {
        if (!window.pusher) {
            console.error('Pusher not initialized');
            return;
        }

        // Subscribe to branch-specific channel
        var channel = window.pusher.subscribe('chat.branch.' + branchId);

        // Listen for new messages
        channel.bind('message.sent', function(data) {
            console.log('Received message via Pusher:', data);

            // Only show message if it's from staff (not our own messages)
            if (data.sender_type === 'staff') {
                displayStaffMessage(data);
            }
        });

        // Store channel reference for cleanup
        window.currentChatChannel = channel;

        console.log('Pusher subscribed to channel: chat.branch.' + branchId);

        // Start polling as backup (every 5 seconds)
        startMessagePolling(branchId);
    }

    // Auto-refresh messages via AJAX polling (backup for Pusher)
    var pollingInterval = null;
    var lastMessageId = 0;

    function startMessagePolling(branchId) {
        // Clear any existing polling
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }

        // Poll every 5 seconds
        pollingInterval = setInterval(function() {
            fetchNewMessages(branchId);
        }, 5000);

        console.log('Started message polling for branch:', branchId);
    }

    function fetchNewMessages(branchId) {
        fetch('/api/chat/messages?branch_id=' + branchId, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Failed to fetch messages');
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success && data.data && data.data.length > 0) {
                // Get last message ID from current messages
                var allMessages = messagesContainer.querySelectorAll('.chat-message');
                if (allMessages.length > 0) {
                    // Check if there are new messages since last fetch
                    data.data.forEach(function(message) {
                        if (message.id > lastMessageId) {
                            if (message.sender_type === 'staff') {
                                displayStaffMessage(message);
                            }
                            lastMessageId = message.id;
                        }
                    });
                }
            }
        })
        .catch(function(error) {
            console.error('Error polling messages:', error);
        });
    }

    // Stop polling when chat is closed
    var originalCloseChat = closeChat;
    closeChat = function() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
            console.log('Stopped message polling');
        }
        originalCloseChat();
    };

    // Update handleBranchClick to initialize Pusher and load history
    var originalHandleBranchClick = handleBranchClick;
    handleBranchClick = function(event) {
        var button = event.target;
        var branchId = button.getAttribute('data-branch-id');
        var branchName = button.getAttribute('data-branch-name');

        // Call original function
        originalHandleBranchClick(event);

        // Initialize Pusher for real-time updates
        initializePusherForBranch(branchId);

        // Load chat history
        loadChatHistory(branchId);
    };

});
